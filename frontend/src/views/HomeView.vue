<script setup>

import SideMenu from "@/components/side_menu/SideMenu.vue";
import BookList from "@/components/books/BookList.vue";
import {useBookStore} from "@/stores/bookStore.js";
import {onMounted, ref} from "vue";
import {useRoute, useRouter} from "vue-router";


const store = useBookStore();
const per_page = 4;

const route = useRoute();
const router = useRouter();

onMounted( () => {
    fetchData(route.params.page);
});

const options = ref(null);

const filter_options_changed_handler = () => {
    // options.value = new_options;
    fetchData(1);
}

const page_changed_handler = (page) => {
    router.push('/' + page);
    fetchData(page);
}

const fetchData = async (page) => {
    await store.fetchBooks(page, per_page);
}

</script>

<template>
    <div class="d-flex flex-grow-1">
        <SideMenu 
            class="side_menu"
            @filter_options_changed="filter_options_changed_handler"
        />
        <div class="content">
            <BookList
                :books="store.books"
                :meta="store.meta"
                :totalBooksCount="store.meta.total"
                @page_changed="page_changed_handler"
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