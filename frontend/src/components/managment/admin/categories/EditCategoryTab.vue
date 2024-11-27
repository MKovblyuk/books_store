<script setup>
import axios from 'axios';
import { ref, watchEffect } from 'vue';
import CategoriesTable from './CategoriesTable.vue';
import AddCategoryTab from './AddCategoryTab.vue';
import DeleteCategoryModal from '@/components/widgets/modals/DeleteCategoryModal.vue';

const props = defineProps(['category']);
const emit = defineEmits(['categoryUpdated', 'tryReturn']);

const errors = ref();
const categoryUpdated = ref(false);

const newCategoryData = ref({
    name: ''
});
const childCategories = ref([]);
const deleteModalRef = ref();

const EDIT_SUBCATEGORY_TAB = 'edit_sub_tab';
const ADD_SUBCATEGORY_TAB = 'add_sub_tab';
const MAIN_TAB = 'main_tab';
const activeTab = ref(MAIN_TAB);

const selectedCategory = ref();

watchEffect(() => {
    newCategoryData.value = {...props.category};
    fetchChildCategories();
});

async function updateCategory() {
    try {
        const response = await axios.patch('categories/' + props.category.id, newCategoryData.value);

        if (response.status === 200) {
            categoryUpdated.value = true;
            alert('Category updated');
            emit('categoryUpdated');
        }
    } catch(e) {
        if (e.response.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
}

async function fetchChildCategories() {
    const response = await axios.get('categories/' + props.category.id + '/children');

    if (response.status === 200) {
        childCategories.value = response.data.data;
    }
}

function showEditCategoryTab(category) {
    selectedCategory.value = category;
    activeTab.value = EDIT_SUBCATEGORY_TAB;
}

function showDeleteCategoryModal(category) {
    selectedCategory.value = category;
    deleteModalRef.value.click();
}

</script>

<template>
    <div>
        <EditCategoryTab 
            v-if="activeTab === EDIT_SUBCATEGORY_TAB"
            class="mt-2"
            :category="selectedCategory"
            @try-return="activeTab = MAIN_TAB"
            @category-updated="fetchChildCategories"
        />

        <div v-if="activeTab === MAIN_TAB">
            <div>
                <button class="btn btn-success" @click="emit('tryReturn')">
                    &lArr;
                </button>
            </div>
            <div>
                <div class="mb-3">
                    <label for="firstNameInput" class="form-label">
                        Name
                    </label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="firstNameInput"
                        v-model="newCategoryData.name"
                    >
                    <div class="text-danger">{{ errors?.name?.[0] }}</div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="p-1">
                        <button class="btn btn-primary me-1" @click="emit('tryReturn')">Cancel</button>
                        <button class="btn btn-primary" @click="updateCategory">Update</button>
                    </div>
                    <div class="p-1">
                        <button class="btn btn-success" @click="activeTab = ADD_SUBCATEGORY_TAB">Add</button>
                    </div>
                </div>
          
            </div>

            <CategoriesTable
                :categories="childCategories"
                @edit-btn-clicked="showEditCategoryTab"
                @delete-btn-clicked="showDeleteCategoryModal"
            />

            <button 
                hidden 
                data-bs-toggle="modal" 
                data-bs-target="#deleteSubCatModal"
                ref="deleteModalRef"
            ></button>
            <DeleteCategoryModal 
                title="Delete category" 
                ok-btn-text="Delete" 
                id="deleteSubCatModal"
                :category="selectedCategory"
                @category-deleted="fetchChildCategories"
            />
        </div>

        <AddCategoryTab 
            v-if="activeTab === ADD_SUBCATEGORY_TAB"
            class="mt-2"
            :parent-category="category"
            @try-return="activeTab = MAIN_TAB"
            @category-created="fetchChildCategories"
        />
    </div>
</template>