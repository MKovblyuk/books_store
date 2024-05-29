<script setup>

import BookCard from "@/components/books/BookCard.vue";
</script>

<template>
    <ul class="list-group list-group-horizontal list-group-flush">
        <li v-for="i in 15" class="list-group-item">
            <BookCard/>
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