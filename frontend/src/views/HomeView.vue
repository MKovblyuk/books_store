<script setup>

import SideMenu from "@/components/side_menu/SideMenu.vue";
import BookList from "@/components/books/BookList.vue";
import {useBookStore} from "@/stores/bookStore.js";
import {onMounted, ref} from "vue";
import {useRoute, useRouter} from "vue-router";

const store = useBookStore();
const route = useRoute();
const router = useRouter();

onMounted( () => {
    fetchData(route.params.page);
});


const pageChangedHandler = (page) => {
    router.push('/' + page);
    fetchData(page);
}

const fetchData = async (page) => {
    await store.fetchBooks(page);
}

</script>

<template>
    <div class="d-flex flex-grow-1">
        <SideMenu 
            class="side_menu"
            @filter_options_changed="fetchData(1)"
        />
        <div class="content">
            <BookList
                :books="store.books"
                :meta="store.meta"
                :totalBooksCount="store.meta.total"
                @page_changed="pageChangedHandler"
            />
        </div>
    </div>
</template>

<style scoped>
.side_menu {
    width: 15%;
    border-right: 1px solid #888888;
}
.content {
    width: 85%;
}
</style>