<script setup>
import BookCard from './BookCard.vue';

const props = defineProps(['books', 'meta']);

</script>

<template>
    <div class="d-flex flex-wrap justify-content-between p-2">
        <BookCard 
            v-for="book in books" 
            :book 
            :key="book.id"
            class="mt-2"
        />
    </div>
</template>