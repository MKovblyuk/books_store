<script setup>
import CartItem from "@/components/cart/CartItem.vue";
import { useCartStore } from "@/stores/cartStore";


const cartStore = useCartStore();

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
                     {{ cartStore.items.length }}
                </div>
                <button class="btn btn-outline-dark" @click="cartStore.$reset()">Remove All</button>
            </div>

            <div>
                <CartItem v-for="item in cartStore.items" :item class="mt-2"/>
            </div>

            <div class="mt-3">
                 <div>Total Price {{ cartStore.totalPrice }}</div>
                <RouterLink 
                    to="/order" 
                    class="btn btn-primary w-100"
                    :class="{disabled: cartStore.items.length <= 0}"
                >
                    To Order
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>