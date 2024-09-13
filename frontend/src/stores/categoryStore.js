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

    return {categories, isFetched, fetchCategories, getCategoryById}
});