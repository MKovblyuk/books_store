import {defineStore} from "pinia";
import {ref} from "vue";
import axios from "axios";
import { useFilterStore } from "./filterStore";
import { useSortingStore } from "./sortingStore";

export const useBookStore = defineStore('book', () => {
    const books = ref([]);
    const links = ref({});
    const meta = ref({});
    const relatedBooks = ref([]);
    const book = ref({});
    const bookIsLoaded = ref(false);
    const perPage = ref(4);

    const booksIsFetched = ref(false);
    let currentPage = 0;
    let currentBookId = null;

    const filterStore = useFilterStore();
    const sortingStore = useSortingStore();

    async function fetchBooks(page = 1, per_page = perPage.value) {
        let params = {
            page,
            per_page,
            ...filterStore.queryParamsObject,
            'sort': sortingStore.param
        }

        if (!booksIsFetched.value || currentPage !== page) {
            const response = await axios.get('books', {params});
            books.value = response.data.data;
            links.value = response.data.links;
            meta.value = response.data.meta;

            currentPage = page;
            booksIsFetched.value = true;
        }
    }

    async function fetchRelatedBooks(bookId, page, per_page) {
        const params = {
            page, per_page
        }

        const response = await axios.get('books/' + bookId + '/related', params);
        relatedBooks.value = response.data.data;
    }

    async function fetchBook(id) {
        if (id !== currentBookId) {
            bookIsLoaded.value = false;

            const response = await axios.get(`books/${id}?include=publisher,category,authors,fragments`);
            book.value = response.data.data;

            bookIsLoaded.value = true;
            currentBookId = id;
        }
    }

    return { 
        books, 
        links, 
        meta, 
        fetchBooks, 
        relatedBooks, 
        fetchRelatedBooks, 
        book, 
        bookIsLoaded, 
        fetchBook
    };
});