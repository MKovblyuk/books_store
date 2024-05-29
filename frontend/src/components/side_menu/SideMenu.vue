<script setup>
import {ref} from "vue";
import CategoriesList from "@/components/categories/CategoriesList.vue";
import SideMenuCategoryItem from "@/components/side_menu/SideMenuCategoryItem.vue";
import Filter from "@/components/filter/Filter.vue";


</script>

<template>
    <nav class="p-2">
        <SideMenuCategoryItem/>
        <Filter class="mt-2"/>
    </nav>

</template>

<style scoped>

</style>