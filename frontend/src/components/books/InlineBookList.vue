<script setup>

import BookCard from "@/components/books/BookCard.vue";

const props = defineProps(['books']);



</script>

<template>
    <ul class="list-group list-group-horizontal list-group-flush">
        <li v-for="book in books" :key="book.id" class="list-group-item">
            <BookCard :book @click="$emit('book_card_click', book.id)"/>
        </li>
    </ul>
</template>

<style scoped>
    .list-group{
        overflow-y: hidden;
    }
    .list-group-item{
        padding: 0;
    }
    .list-group > *:not(:last-child) {
        margin-right: 15px;
    }
</style>