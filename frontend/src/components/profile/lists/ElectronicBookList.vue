<script setup>
import ElectronicBookCard from './ElectronicBookCard.vue';

const props = defineProps(['books']);

</script>

<template>
        <div class="d-flex flex-wrap justify-content-between p-2">
        <ElectronicBookCard 
            v-for="book in books" 
            :book 
            :key="book.id"
            class="mt-2"
            @read="(book, extension) => $emit('read', book, extension)"
            @download="(book, extension) => $emit('download', book, extension)"
        />
    </div>
</template>