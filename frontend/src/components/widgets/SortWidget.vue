<script setup>
import { useBookStore } from '@/stores/bookStore';
import { useSortingStore } from '@/stores/sortingStore';

const sortingStore = useSortingStore();
const bookStore = useBookStore();

</script>

<template>
    <select 
        class="form-select" 
        aria-label="Default select example" 
        v-model="sortingStore.param"
        @change="bookStore.fetchBooks"
    >
        <option :value="sortingStore.SELLING_COUNT">Bestsellers</option>
        <option :value="sortingStore.LIKES">Most liked</option>
        <option :value="sortingStore.PRICE">From the cheapest</option>
        <option :value="sortingStore.PRICE_DESC">From expensive</option>
    </select>
</template>

<style scoped>

</style>