<script setup>

import PaginationBar from '../widgets/PaginationBar.vue';
import BookList from './BookList.vue';

const props = defineProps(['books', 'meta']);

</script>

<template>
    <div>
        <BookList :books/>
        <PaginationBar 
            v-if="books.length > 0"
            @page_changed="page => $emit('page_changed', page)"
            :meta
        />
    </div>
</template>