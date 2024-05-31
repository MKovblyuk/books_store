<script setup>

import BookCard from "@/components/books/BookCard.vue";
import PaginationBar from "@/components/PaginationBar.vue";
import SortWidget from "@/components/widgets/SortWidget.vue";
</script>

<template>
    <div>
        <div class="d-flex justify-content-between p-2 align-items-center">
            <div class="fs-4">
                12423 Books
            </div>
            <SortWidget class="w-25"/>
        </div>

        <div class="d-flex flex-wrap justify-content-between p-2">
            <div v-for="item in 32" class="m-2">
                <BookCard/>
            </div>
        </div>

        <PaginationBar/>
    </div>
</template>

<style scoped>

</style>