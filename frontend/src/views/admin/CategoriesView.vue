<script setup>
import PaginationBar from '@/components/widgets/PaginationBar.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import CategoriesTable from '@/components/managment/admin/categories/CategoriesTable.vue';
import EditCategoryTab from '@/components/managment/admin/categories/EditCategoryTab.vue';
import DeleteCategoryModal from '@/components/widgets/modals/DeleteCategoryModal.vue';
import AddCategoryTab from '@/components/managment/admin/categories/AddCategoryTab.vue';

const deleteModalRef = ref();

const categories = ref([]);
const meta = ref();
const selectedCategory = ref();

const PER_PAGE = 8;

const MAIN_TAB = 'main_tab';
const EDIT_CATEGORY_TAB = 'edit_category_tab';
const ADD_CATEGORY_TAB = 'add_category_tab';
const activeTab = ref(MAIN_TAB);

onMounted(() => {
    fetchCategories();
})

async function fetchCategories(page = 1) {
    const response = await axios.get('/categories', {
        params: {
            page: page,
            per_page: PER_PAGE,
        }
    });


    categories.value = response.data.data;
    meta.value = response.data.meta;
}

function showEditCategoryTab(category) {
    selectedCategory.value = category;
    activeTab.value = EDIT_CATEGORY_TAB;
}

function showDeleteCategoryModal(category) {
    selectedCategory.value = category;
    deleteModalRef.value.click();
}

</script>

<template>
    <div>
        <div v-show="activeTab === MAIN_TAB">
            <button class="btn btn-success mb-2" @click="activeTab = ADD_CATEGORY_TAB">
                Add
            </button>

            <CategoriesTable
                :categories
                @edit-btn-clicked="showEditCategoryTab"
                @delete-btn-clicked="showDeleteCategoryModal"
            />

            <PaginationBar 
                v-if="meta"
                :meta
                @page_changed="newPage => fetchCategories(newPage)"
            />

            <button 
                hidden 
                data-bs-toggle="modal" 
                data-bs-target="#deleteModal"
                ref="deleteModalRef"
            ></button>
            <DeleteCategoryModal 
                title="Delete category" 
                ok-btn-text="Delete" 
                id="deleteModal"
                :category="selectedCategory"
                @category-deleted="fetchCategories"
            />
        </div>

        <EditCategoryTab 
            v-if="activeTab === EDIT_CATEGORY_TAB"
            class="mt-2"
            :category="selectedCategory"
            @try-return="activeTab = MAIN_TAB"
            @category-updated="fetchCategories"
        />

        <AddCategoryTab 
            v-if="activeTab === ADD_CATEGORY_TAB"
            class="mt-2"
            @category-created=fetchCategories
            @try-return="activeTab = MAIN_TAB"
        /> 
    </div>
</template>