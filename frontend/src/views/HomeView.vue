<script setup>

import SideMenu from "@/components/side_menu/SideMenu.vue";
import BookList from "@/components/books/BookList.vue";
</script>

<template>
    <div class="d-flex flex-grow-1">
        <SideMenu class="side_menu"/>
        <div class="content">
            <BookList />
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