<script setup>
import { RouterLink } from 'vue-router';

const menuItemClasses = "btn btn-primary mt-1";

</script>

<template>
    <nav class="d-flex flex-column">
        <RouterLink :class=menuItemClasses to="/editor/books">
            Books
        </RouterLink>
        <RouterLink :class=menuItemClasses to="/editor/authors">
            Authors
        </RouterLink>
        <RouterLink :class=menuItemClasses to="/editor/publishers">
            Publishers
        </RouterLink>
        <RouterLink :class=menuItemClasses to="/editor/categories">
            Categories
        </RouterLink>
        <RouterLink :class=menuItemClasses to="/editor/reviews">
            Reviews
        </RouterLink>
    </nav>
</template>