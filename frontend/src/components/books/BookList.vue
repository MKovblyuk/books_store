<script setup>

import BookCard from "@/components/books/BookCard.vue";

const props = defineProps(['books']);

</script>

<template>
    <div class="d-flex flex-wrap justify-content-between p-2">
        <div v-for="book in books" :key="book.id" class="m-2">
            <BookCard :book @click="$router.push('/book/' + book.id)"/>
        </div>
    </div>
</template>