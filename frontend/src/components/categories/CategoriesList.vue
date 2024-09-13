<script setup>
import { useBookStore } from '@/stores/bookStore';
import { useFilterStore } from '@/stores/filterStore';

const props = defineProps(['categories']);
const emit = defineEmits(['category_selected']);

function selectCategory(id) {
    useFilterStore().category = id;
    useBookStore().fetchBooks();
    emit('category_selected');
}

</script>

<template>
    <div>
        <button 
            class="btn btn-primary mb-2 w-100"
            @click="selectCategory(null)"
        >
            All
        </button>
        <div v-for="category in categories" :key="category.id" class="mb-2">
            <div v-if="category.children.length !== 0" class="btn-group w-100">
                <button type="button" class="btn btn-primary dropdown-toggle w-100" data-bs-toggle="dropdown" aria-expanded="false">
                    {{category.name}}
                </button>
                <ul class="dropdown-menu w-75">
                    <li>
                        <button 
                            class="dropdown-item" 
                            type="button"
                            @click="selectCategory(category.id)"
                        >
                            All
                        </button>
                    </li>
                    <li v-for="subcategory in category.children" :key="subcategory.id">
                        <button 
                            class="dropdown-item" 
                            type="button"
                            @click="selectCategory(subcategory.id)"
                        >
                            {{subcategory.name}}
                        </button>
                    </li>
                </ul>
            </div>
            <div v-else>
                <button class="btn btn-primary w-100">
                    {{category.name}}
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>