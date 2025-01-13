<script setup>

import { useUserStore } from '@/stores/userStore';
import BookListWithPagination from '@/components/books/BookListWithPagination.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';


const userStore = useUserStore();
const likedBooks = ref([]);
const meta = ref();
const isFetched = ref(false);
const PER_PAGE = 20;

async function fetchLikedBooks(page = 1) {
    try {
        const response = await axios.get('users/' + userStore.user.id + '/likedBooks', {
            params: {
                per_page: PER_PAGE,
                page: page,
            }
        });

        likedBooks.value = response.data.data;
        meta.value = response.data.meta;
        isFetched.value = true;
    } catch (e) {
        console.log('Error in fetching liked books', e);
    }
}

onMounted(() => {
    fetchLikedBooks();
});

</script>

<template>
    <section>
        Liked books
        <BookListWithPagination 
            :books="likedBooks"
            :meta
            @page_changed="page => fetchLikedBooks(page)"
        />
        
    </section>
</template>