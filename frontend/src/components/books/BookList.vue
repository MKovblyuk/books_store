<script setup>

import BookCard from "@/components/books/BookCard.vue";
import PaginationBar from "@/components/PaginationBar.vue";
import SortWidget from "@/components/widgets/SortWidget.vue";

const props = defineProps(['books', 'meta', 'totalBooksCount']);

</script>

<template>
    <div>
        <div class="d-flex justify-content-between p-2 align-items-center">
            <div class="fs-4">
                {{totalBooksCount}} Books
            </div>
            <SortWidget class="w-25"/>
        </div>

        <div class="d-flex flex-wrap justify-content-between p-2">
            <div v-for="book in books" :key="book.id" class="m-2">
                <BookCard :book @click="$router.push('/book/' + book.id)"/>
            </div>
        </div>

        <PaginationBar 
            v-if="books.length > 0"
            :meta 
            @page_changed="(page) => $emit('page_changed', page)"
        />
    </div>
</template>

<style scoped>

</style>