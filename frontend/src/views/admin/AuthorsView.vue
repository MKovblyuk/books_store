<script setup>

import AuthorsTable from '@/components/managment/admin/authors/AuthorsTable.vue';
import DeleteAuthorModal from '@/components/widgets/modals/DeleteAuthorModal.vue';
import EditAuthorTab from '@/components/managment/admin/authors/EditAuthorTab.vue';
import PaginationBar from '@/components/widgets/PaginationBar.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import FilterAuthorsForm from '@/components/managment/admin/authors/FilterAuthorsForm.vue';
import AddAuthorTab from '@/components/managment/admin/authors/AddAuthorTab.vue';

const deleteModalRef = ref();
const showFilterForm = ref(false);

const authors = ref([]);
const meta = ref();
const selectedAuthor = ref();

const PER_PAGE = 8;
const filterParams = ref({});
const sortParam = ref();

const MAIN_TAB = 'main_tab';
const EDIT_AUTHOR_TAB = 'edit_author_tab';
const ADD_AUTHOR_TAB = 'add_author_tab';
const activeTab = ref(MAIN_TAB);

onMounted(() => {
    fetchAuthors();
})

async function fetchAuthors(page = 1) {
    const response = await axios.get('/authors', {
        params: {
            page: page,
            per_page: PER_PAGE,
            sort: sortParam.value,
            ...filterParams.value
        }
    });


    authors.value = response.data.data;
    meta.value = response.data.meta;
}

function setFilterParams(data) {
    filterParams.value['filter[first_name]'] = data?.firstName;
    filterParams.value['filter[last_name]']  = data?.lastName;
    filterParams.value['filter[description]']  = data?.description;
}

function filterChangedHandler(data) {
    setFilterParams(data);
    fetchAuthors();
}

function sortingChangedHandler(isAsc, column) {
    sortParam.value = (isAsc ? '-' : '') + column;
    fetchAuthors();
}

function showEditAuthorTab(author) {
    selectedAuthor.value = author;
    activeTab.value = EDIT_AUTHOR_TAB;
}

function showDeleteAuthorModal(author) {
    selectedAuthor.value = author;
    deleteModalRef.value.click();
}

</script>

<template>
    <div>
        <div class="mb-2">
            <button class="btn btn-success me-2" @click="activeTab = ADD_AUTHOR_TAB">
                Add Author
            </button>

            <button class="btn btn-primary" @click="showFilterForm = !showFilterForm">
                {{ showFilterForm ? 'Hide' : 'Search' }}
            </button>

            <FilterAuthorsForm
                class="mt-1"
                v-show="showFilterForm"
                @filter-changed="filterChangedHandler"
            />
        </div>

        <div v-show="activeTab === MAIN_TAB">
            <AuthorsTable
                :authors
                @sorting-changed="sortingChangedHandler"
                @edit-btn-clicked="showEditAuthorTab"
                @delete-btn-clicked="showDeleteAuthorModal"
            />

            <PaginationBar 
                v-if="meta"
                :meta
                @page_changed="newPage => fetchAuthors(newPage)"
            />

            <button 
                hidden 
                data-bs-toggle="modal" 
                data-bs-target="#deleteModal"
                ref="deleteModalRef"
            ></button>
            <DeleteAuthorModal 
                title="Delete author" 
                ok-btn-text="Delete" 
                id="deleteModal"
                :author="selectedAuthor"
                @author-deleted="fetchAuthors"
            />
        </div>

        <EditAuthorTab 
            v-if="activeTab === EDIT_AUTHOR_TAB"
            class="mt-2"
            :author="selectedAuthor"
            @try-return="activeTab = MAIN_TAB"
            @author-updated="fetchAuthors"
        />

        <AddAuthorTab 
            v-if="activeTab === ADD_AUTHOR_TAB"
            class="mt-2"
            @try-return="activeTab = MAIN_TAB"
            @author-created="fetchAuthors"
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