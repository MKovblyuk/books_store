import {defineStore} from "pinia";
import {ref} from "vue";
import axios from "axios";
import { useFilterStore } from "./filterStore";

export const useBookStore = defineStore('book', () => {
    const books = ref([]);
    const links = ref({});
    const meta = ref({});
    const relatedBooks = ref([]);
    const book = ref({});
    const bookIsLoaded = ref(false);

    // milliseconds
    // there is 30 minutes
    const NO_FETCH_TIME = 1000 * 60 * 30;
    let last_fetch_time = Date.now();
    let current_page = 0;
    let current_book_id = null;

    const filterStore = useFilterStore();

    async function fetchBooks(page, per_page) {
        let params = {
            page,
            per_page,
            ...filterStore.queryParamsObject,
        }

        console.log(params);

        // if (books.value.length === 0 || current_page !== page || Date.now() - last_fetch_time > NO_FETCH_TIME) {
            const response = await axios.get('books', {params});
            books.value = response.data.data;
            links.value = response.data.links;
            meta.value = response.data.meta;

            last_fetch_time = Date.now();
            current_page = page;
            console.log('fetch books');
        // }
    }

    async function fetchRelatedBooks() {
        const response = await axios.get('books');
        relatedBooks.value = response.data.data;
    }

    async function fetchBook(id) {

        if (id !== current_book_id) {
            bookIsLoaded.value = false;
            const response = await axios.get(`books/${id}?include=publisher,category,authors,fragments`);
            book.value = response.data.data;
            bookIsLoaded.value = true;
            current_book_id = id;

            console.log("fetch single book");
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