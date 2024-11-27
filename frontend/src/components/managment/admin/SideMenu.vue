<script setup>
import { RouterLink } from 'vue-router';


const menuItemClasses = "btn btn-primary mt-1";

</script>

<template>
    <nav class="d-flex flex-column">
        <RouterLink :class=menuItemClasses to="/admin/users">
            Users
        </RouterLink>
        <RouterLink :class=menuItemClasses to="/admin/orders">
            Orders
        </RouterLink>
        <RouterLink :class=menuItemClasses to="/admin/books">
            Books
        </RouterLink>
        <RouterLink :class=menuItemClasses to="/admin/authors">
            Authors
        </RouterLink>
        <RouterLink :class=menuItemClasses to="/admin/publishers">
            Publishers
        </RouterLink>
        <RouterLink :class=menuItemClasses to="/admin/categories">
            Categories
        </RouterLink>
        <RouterLink :class=menuItemClasses to="/admin/reviews">
            Reviews
        </RouterLink>
    </nav>
</template>