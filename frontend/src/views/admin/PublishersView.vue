<script setup>

import FilterPublishersForm from '@/components/managment/admin/publishers/FilterPublishersForm.vue';
import PublishersTable from '@/components/managment/admin/publishers/PublishersTable.vue';
import DeletePublisherModal from '@/components/widgets/modals/DeletePublisherModal.vue';
import AddPublisherTab from '@/components/managment/admin/publishers/AddPublisherTab.vue';
import EditPublisherTab from '@/components/managment/admin/publishers/EditPublisherTab.vue';
import PaginationBar from '@/components/widgets/PaginationBar.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const deleteModalRef = ref();
const showFilterForm = ref(false);

const publishers = ref([]);
const meta = ref();
const selectedPublisher = ref();

const PER_PAGE = 8;
const filterParams = ref({});
const sortParam = ref();

const MAIN_TAB = 'main_tab';
const EDIT_PUBLISHER_TAB = 'edit_publisher_tab';
const ADD_PUBLISHER_TAB = 'add_publisher_tab';
const activeTab = ref(MAIN_TAB);

onMounted(() => {
    fetchPublishers();
})

async function fetchPublishers(page = 1) {
    const response = await axios.get('/publishers', {
        params: {
            page: page,
            per_page: PER_PAGE,
            sort: sortParam.value,
            ...filterParams.value
        }
    });


    publishers.value = response.data.data;
    meta.value = response.data.meta;
}

function setFilterParams(data) {
    filterParams.value['filter[name]'] = data?.name;
}

function filterChangedHandler(data) {
    setFilterParams(data);
    fetchPublishers();
}

function sortingChangedHandler(isAsc, column) {
    sortParam.value = (isAsc ? '-' : '') + column;
    fetchPublishers();
}

function showEditPublisherTab(author) {
    selectedPublisher.value = author;
    activeTab.value = EDIT_PUBLISHER_TAB;
}

function showDeletePublisherModal(author) {
    selectedPublisher.value = author;
    deleteModalRef.value.click();
}

</script>

<template>
    <div>
        <div class="mb-2">
            <button class="btn btn-success me-2" @click="activeTab = ADD_PUBLISHER_TAB">
                Add Publisher
            </button>

            <button class="btn btn-primary" @click="showFilterForm = !showFilterForm">
                {{ showFilterForm ? 'Hide' : 'Search' }}
            </button>

            <FilterPublishersForm
                class="mt-1"
                v-show="showFilterForm"
                @filter-changed="filterChangedHandler"
            />
        </div>

        <div v-show="activeTab === MAIN_TAB">
            <PublishersTable
                :publishers
                @sorting-changed="sortingChangedHandler"
                @edit-btn-clicked="showEditPublisherTab"
                @delete-btn-clicked="showDeletePublisherModal"
            />

            <PaginationBar 
                v-if="meta"
                :meta
                @page_changed="newPage => fetchPublishers(newPage)"
            />

            <button 
                hidden 
                data-bs-toggle="modal" 
                data-bs-target="#deleteModal"
                ref="deleteModalRef"
            ></button>
            <DeletePublisherModal 
                title="Delete publisher" 
                ok-btn-text="Delete" 
                id="deleteModal"
                :publisher="selectedPublisher"
                @publisher-deleted="fetchPublishers"
            />
        </div>


        <AddPublisherTab 
            v-if="activeTab === ADD_PUBLISHER_TAB"
            class="mt-2"
            @try-return="activeTab = MAIN_TAB"
            @publisher-created="fetchPublishers"
        />

        <EditPublisherTab 
            v-if="activeTab === EDIT_PUBLISHER_TAB"
            class="mt-2"
            :publisher="selectedPublisher"
            @try-return="activeTab = MAIN_TAB"
            @publisher-updated="fetchPublishers"
        />
    </div>
</template>