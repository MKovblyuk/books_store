<script setup>

import {RouterLink} from "vue-router";
import CartRightSideMenu from "@/components/cart/CartRightSideMenu.vue";
</script>

<template>

<header class="d-flex p-3 justify-content-between align-items-center">
    <div>
        <img
            src="https://w7.pngwing.com/pngs/973/11/png-transparent-phoenix-logo-design-mark-phoenix-fire-thumbnail.png"
            alt="logo"
            width="30px"
            height="30px"
        >
    </div>
    <div class="input-group w-50">
        <input type="text" class="form-control" placeholder="Search" aria-label="Search">
        <button class="btn btn-success" type="submit">Search</button>
    </div>

    <div>
        <button type="button" class="btn btn-primary position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
            Cart
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                99+
                <span class="visually-hidden">unread messages</span>
            </span>
        </button>
        <RouterLink to="/login" class="btn btn-primary ms-2">Sign In</RouterLink>
        <RouterLink to="/profile" class="btn btn-primary ms-2">Profile</RouterLink>
    </div>

    <CartRightSideMenu/>
</header>

</template>

<style scoped>
header {
    background-color: #eceaff;
}
</style>