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
    store.perPage = 20;
    store.fetchBooks(route.params.page);

    selectedCategory.value = useCategoryStore().getCategoryById(filterStore.category);
    subcategories.value = selectedCategory.value?.children;
});

const pageChangedHandler = (page) => {
    router.push('/' + page);
    store.fetchBooks(page);
}

watch(() => filterStore.category, async newCategoryId => {
    selectedCategory.value = useCategoryStore().getCategoryById(newCategoryId);
    subcategories.value = selectedCategory.value?.children;
});

function categoryChangedHandler(id) {
    filterStore.category = id;
    store.fetchBooks(1);
}

</script>

<template>
    <div class="row w-100">
        <SideMenu 
            class="side_menu col-4 col-sm-3 col-lg-2 ps-4"
            @filter_options_changed="store.fetchBooks(1)"
        />
        <div class="col-8 col-sm-9 col-lg-10">
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
    border-right: 1px solid #888888;
}
</style>