<script setup>

import SideMenu from "@/components/side_menu/SideMenu.vue";
import {useBookStore} from "@/stores/bookStore.js";
import {onMounted, ref, watch} from "vue";
import {useRoute, useRouter} from "vue-router";
import InlineCategoriesList from "@/components/categories/InlineCategoriesList.vue";
import CategoriesBreadcrumb from "@/components/categories/CategoriesBreadcrumb.vue";
import { useFilterStore } from "@/stores/filterStore";
import { useCategoryStore } from "@/stores/categoryStore";
import BooksSection from "@/components/books/BooksSection.vue";

const store = useBookStore();
const route = useRoute();
const router = useRouter();

const filterStore = useFilterStore();
const subcategories = ref([]);
const selectedCategory = ref();

onMounted(() => {
    fetchData(route.params.page);
});

const pageChangedHandler = (page) => {
    router.push('/' + page);
    fetchData(page);
}

const fetchData = async (page) => {
    await store.fetchBooks(page);
}

watch(() => filterStore.category, async newCategoryId => {
    selectedCategory.value = useCategoryStore().getCategoryById(newCategoryId);
    subcategories.value = selectedCategory.value?.children;
});

function categoryChangedHandler(id) {
    filterStore.category = id;
    fetchData(1);
}

</script>

<template>
    <div class="d-flex flex-grow-1">
        <SideMenu 
            class="side_menu"
            @filter_options_changed="fetchData(1)"
        />
        <div class="content">
            <CategoriesBreadcrumb 
                :category="selectedCategory"
                @category_changed="categoryChangedHandler"
            />
            <InlineCategoriesList
                :categories="subcategories"
                @category_changed="categoryChangedHandler"
            />
            <BooksSection
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