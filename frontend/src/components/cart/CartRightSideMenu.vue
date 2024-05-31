<script setup>
import CartItem from "@/components/cart/CartItem.vue";

const books = [
    {
        name: "some",
        price: 34234,
        quantity: 1
    },
    {
        name: "some2",
        price: 213,
        quantity: 1
    },
    {
        name: "some3",
        price: 2,
        quantity: 1
    },
    {
        name: "some",
        price: 34234,
        quantity: 1
    },
    {
        name: "some2",
        price: 213,
        quantity: 1
    },
    {
        name: "some3",
        price: 2,
        quantity: 1
    },
    {
        name: "some",
        price: 34234,
        quantity: 1
    },
    {
        name: "some2",
        price: 213,
        quantity: 1
    },
    {
        name: "some3",
        price: 2,
        quantity: 1
    },
    {
        name: "some",
        price: 34234,
        quantity: 1
    },
    {
        name: "some2",
        price: 213,
        quantity: 1
    },
    {
        name: "some3",
        price: 2,
        quantity: 1
    },
    {
        name: "some",
        price: 34234,
        quantity: 1
    },
    {
        name: "some2",
        price: 213,
        quantity: 1
    },
    {
        name: "some3",
        price: 2,
        quantity: 1
    },
    {
        name: "some",
        price: 34234,
        quantity: 1
    },
    {
        name: "some2",
        price: 213,
        quantity: 1
    },
    {
        name: "some3",
        price: 2,
        quantity: 1
    },
    {
        name: "some",
        price: 34234,
        quantity: 1
    },
    {
        name: "some2",
        price: 213,
        quantity: 1
    },
    {
        name: "some3",
        price: 2,
        quantity: 1
    },

];
</script>

<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Cart Items</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    All {{books.length}}
                </div>
                <button class="btn btn-outline-dark">Remove All</button>
            </div>

            <div>
                <CartItem v-for="item in books" :item class="mt-2"/>
            </div>

            <div class="mt-3">
                <div>Total Price 3453</div>
                <RouterLink to="/order" class="btn btn-primary w-100">To Order</RouterLink>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>