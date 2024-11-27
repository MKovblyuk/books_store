<script setup>
import PaginationBar from '@/components/widgets/PaginationBar.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import BooksTable from '@/components/managment/admin/books/BooksTable.vue';
import FilterBooksForm from '@/components/managment/admin/books/FilterBooksForm.vue';
import DeleteBookModal from '@/components/widgets/modals/DeleteBookModal.vue';
import AddBookTab from '@/components/managment/admin/books/AddBookTab.vue';
import EditBookTab from '@/components/managment/admin/books/EditBookTab.vue';

const deleteModalRef = ref();
const showFilterForm = ref(false);

const books = ref([]);
const meta = ref();
const selectedBook = ref();

const PER_PAGE = 8;
const filterParams = ref({});
const sortParam = ref();

const MAIN_TAB = 'main_tab';
const EDIT_BOOK_TAB = 'edit_book_tab';
const ADD_BOOK_TAB = 'add_book_tab';
const activeTab = ref(MAIN_TAB);

onMounted(() => {
    fetchBooks();
})

async function fetchBooks(page = 1) {
    const response = await axios.get('/books', {
        params: {
            page: page,
            per_page: PER_PAGE,
            sort: sortParam.value,
            ...filterParams.value,
            'include': 'category,publisher',
        }
    });

    books.value = response.data.data;
    meta.value = response.data.meta;
}

function setFilterParams(data) {
    filterParams.value['filter[id]'] = data?.id;
    filterParams.value['filter[name]']  = data?.name;
    filterParams.value['filter[publication_year]']  = data?.publicationYear;
    filterParams.value['filter[publisher_id]']  = data?.publishers?.join(',');
    filterParams.value['filter[author_id]']  = data?.authors?.join(',');
    filterParams.value['filter[language]']  = data?.languages?.join(',');
    filterParams.value['filter[format]']  = data?.bookFormats?.join(',');
    filterParams.value['filter[category_id]']  = data?.categories?.join(',');
    filterParams.value['filter[price_range]']  = data?.priceFrom ?? '0' + ',' + (data?.priceTo ?? '');
    filterParams.value['filter[created_at]']  = data?.createdAt;
    filterParams.value['filter[updated_at]']  = data?.updatedAt;
}

function filterChangedHandler(data) {
    setFilterParams(data);
    fetchBooks();
}

function sortingChangedHandler(isAsc, column) {
    sortParam.value = (isAsc ? '-' : '') + column;
    fetchBooks();
}

function showEditBookTab(user) {
    selectedBook.value = user;
    activeTab.value = EDIT_BOOK_TAB;
}

function showDeleteBookModal(user) {
    selectedBook.value = user;
    deleteModalRef.value.click();
}
</script>

<template>
    <div>
        <div v-show="activeTab === MAIN_TAB">
            <div class="mb-2">
                <button class="btn btn-primary" @click="showFilterForm = !showFilterForm">
                    {{ showFilterForm ? 'Hide' : 'Search' }}
                </button>

                <button class="btn btn-success ms-1" @click="activeTab = ADD_BOOK_TAB">
                    Add
                </button>

                <FilterBooksForm
                    v-show="showFilterForm"
                    @filter-changed="filterChangedHandler"
                    class="mb-1"
                />
            </div>

            <BooksTable
                :books
                @sorting-changed="sortingChangedHandler"
                @edit-btn-clicked="showEditBookTab"
                @delete-btn-clicked="showDeleteBookModal"
            />

            <PaginationBar 
                v-if="meta"
                :meta
                @page_changed="newPage => fetchBooks(newPage)"
            />

            <button 
                hidden 
                data-bs-toggle="modal" 
                data-bs-target="#deleteModal"
                ref="deleteModalRef"
            ></button>
            <DeleteBookModal 
                title="Delete book" 
                ok-btn-text="Delete" 
                id="deleteModal"
                :book="selectedBook"
                @book-deleted="fetchBooks"
            />
        </div>
<!-- 
        <EditUserTab 
            v-if="activeTab === EDIT_BOOK_TAB"    
            class="mt-2"
            :user="selectedBook"
            @try-return="activeTab = MAIN_TAB"
            @userUpdated="fetchBooks"
        />

        

        <UserDetailsTab 
            v-if="activeTab === ADD_BOOK_TAB"
            class="mt-2"
            :user="selectedBook"
            @try-return="activeTab = MAIN_TAB"
        /> -->

        <AddBookTab
            v-if="activeTab === ADD_BOOK_TAB"
            class="mt-2"
            @book-created="fetchBooks"
            @try-return="activeTab = MAIN_TAB"
        />
        <EditBookTab 
            v-if="activeTab === EDIT_BOOK_TAB"    
            class="mt-2"
            :bookId="selectedBook.id"
            @try-return="activeTab = MAIN_TAB"
            @bookUpdated="fetchBooks"
        />
    </div>
</template>

<style scoped>
@media screen and (max-width:1400px) {
    table {
        font-size: 0.6rem !important;
    }
}
</style>