<script setup>
import { useBookStore } from '@/stores/bookStore';
import { useCategoryStore } from '@/stores/categoryStore';
import { useFilterStore } from '@/stores/filterStore';
import { ref, watch } from 'vue';

const filterStore = useFilterStore();
const categories = ref([]);

watch(() => filterStore.category, async newCategoryId => {
    categories.value = useCategoryStore().getCategoryById(newCategoryId)?.children;
});

function selectCategory(id) {
    filterStore.category = id;
    useBookStore().fetchBooks();
}
</script>

<template>
    <template v-if="filterStore.category">
        <div class="p-2 d-flex bg-light">
            <button 
                v-for="category in categories" :key="category.id"
                class="btn btn-outline-success mx-1"
                @click="selectCategory(category.id)"
            >
                {{ category.name }}
            </button>
        </div>
    </template>
</template>