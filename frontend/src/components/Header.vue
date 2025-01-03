<script setup>

import {RouterLink} from "vue-router";
import CartRightSideMenu from "@/components/cart/CartRightSideMenu.vue";
import { useCartStore } from "@/stores/cartStore";
import { useUserStore } from "@/stores/userStore";
import { useFilterStore } from "@/stores/filterStore";
import { useBookStore } from "@/stores/bookStore";
import { UserRoles } from "@/enums/userRoles";

const cartStore = useCartStore();
const userStore = useUserStore();
const filterStore = useFilterStore();
const bookStore = useBookStore();

</script>

<template>

<header class="d-flex p-2 justify-content-between align-items-center">
    <div>
        <RouterLink to="/home">
            <img
                src="@/assets/icons/book_store_logo.png"
                alt="logo"
                width="50rem"
                height="50rem"
            >
        </RouterLink>
    </div>
    <div class="input-group w-50">
        <input 
            type="text" 
            class="form-control" 
            placeholder="Search" 
            aria-label="Search"
            v-model="filterStore.bookName"
            @keydown.enter="bookStore.fetchBooks"
        >
        <button 
            class="btn btn-success" 
            type="submit"
            @click="bookStore.fetchBooks"
        >
            Search
        </button>
    </div>

    <div>
        <button type="button" class="btn btn-primary position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
            Cart
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ cartStore.items.length }}
                <span class="visually-hidden">unread messages</span>
            </span>
        </button>
        <template v-if="userStore.authorized">
            <RouterLink 
                to="/admin" 
                class="btn btn-primary ms-2"
                v-if="userStore.user.role === UserRoles.Admin"
            >
                Dashboard
            </RouterLink>
            <RouterLink 
                to="/editor" 
                class="btn btn-primary ms-2"
                v-if="userStore.user.role === UserRoles.Editor"
            >
                Dashboard
            </RouterLink>
            <RouterLink to="/profile" class="btn btn-primary ms-2">Profile</RouterLink>
            <RouterLink to="/home" class="btn btn-primary ms-2" @click="userStore.logout">Logout</RouterLink>
        </template>
        <template v-else>
            <RouterLink to="/login" class="btn btn-primary ms-2">Sign In</RouterLink>
            <RouterLink to="/register" class="btn btn-primary ms-2">Register</RouterLink>
        </template>
    </div>

    <CartRightSideMenu/>
</header>

</template>

<style scoped>
header {
    background-color: #eceaff;
}
</style>