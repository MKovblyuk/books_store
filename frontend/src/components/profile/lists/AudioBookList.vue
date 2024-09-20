<script setup>
import AudioBookCard from './AudioBookCard.vue';

const props = defineProps(['books']);

</script>

<template>
        <div class="d-flex flex-wrap justify-content-between p-2">
        <AudioBookCard 
            v-for="book in books" 
            :book 
            :key="book.id"
            class="mt-2"
            @listen="(book, extension) => $emit('listen', book, extension)"
            @download="(book, extension) => $emit('download', book, extension)"
        />
    </div>
</template>