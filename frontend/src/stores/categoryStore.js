import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useCategoryStore = defineStore('category', () => {
    const categories = ref([]);
    const isFetched = ref(false);

    async function  fetchCategories() {
        if (!isFetched.value) {
            const response = await axios.get('/categories');
            categories.value = response.data.data;
            isFetched.value = true;
        }
    }

    function getCategoryById(id) {
        if (!isFetched.value) {
            fetchCategories();
        }

        return getById(categories.value, id);
    }

    function getParentsById(id) {
        if (!isFetched.value) {
            fetchCategories();
        }

        let parents = [];
        let parent = getParentCategory(getCategoryById(id));

        while (parent) {
            parents.push(parent);
            parent = getParentCategory(parent);
        }

        return parents;
    }

    function getParentCategory(category) {
        if (category == null || category.parentId === 1) {
            return null;
        }

        return getCategoryById(category.parentId);
    }

    function getById(categories, id) {
        for (let category of categories) {
            if (category.id === id) {
                return category;
            }

            const childCategory = getById(category.children, id);
            if (childCategory) {
                return childCategory;
            }
        }
    }

    return {
        categories, 
        isFetched, 
        fetchCategories, 
        getCategoryById, 
        getParentsById,
        getParentCategory,
        getParentsById
    }
});