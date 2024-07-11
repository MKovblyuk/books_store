<script setup>

import {RouterLink} from "vue-router";
import CartRightSideMenu from "@/components/cart/CartRightSideMenu.vue";
import { useCartStore } from "@/stores/cartStore";
import { useUserStore } from "@/stores/userStore";

const cartStore = useCartStore();
const userStore = useUserStore();

console.log(userStore.isAuthorized());

</script>

<template>

<header class="d-flex p-3 justify-content-between align-items-center">
    <div>
        <RouterLink to="/1">
            <img
                src="https://w7.pngwing.com/pngs/973/11/png-transparent-phoenix-logo-design-mark-phoenix-fire-thumbnail.png"
                alt="logo"
                width="30px"
                height="30px"
            >
        </RouterLink>
    </div>
    <div class="input-group w-50">
        <input type="text" class="form-control" placeholder="Search" aria-label="Search">
        <button class="btn btn-success" type="submit">Search</button>
    </div>

    <div>
        <button type="button" class="btn btn-primary position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
            Cart
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ cartStore.items.length }}
                <span class="visually-hidden">unread messages</span>
            </span>
        </button>
        <template v-if="userStore.isAuthorized()">
            <RouterLink to="/profile" class="btn btn-primary ms-2">Profile</RouterLink>
            <button class="btn btn-primary ms-2" @click="userStore.logout">Logout</button>
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