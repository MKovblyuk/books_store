<script setup>
import SortWidget from "@/components/widgets/SortWidget.vue";
import BookListWithPagination from "./BookListWithPagination.vue";

const props = defineProps(['books', 'meta', 'totalBooksCount']);

</script>

<template>
    <section>
        <div class="d-flex justify-content-between p-2 align-items-center">
            <div class="fs-4">
                {{totalBooksCount}} Books
            </div>
            <SortWidget class="w-25"/>
        </div>

        <BookListWithPagination 
            :books
            :meta
            @page_changed="(page) => $emit('page_changed', page)"
        />
    </section>
</template>