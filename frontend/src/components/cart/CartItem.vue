<script setup>
import { useCartStore } from '@/stores/cartStore';

const props = defineProps(['item']);
const cartStore = useCartStore();

function increaseQuantity()
{
    props.item.increaseQuantity();
}

function decreaseQuantity()
{
    props.item.decreaseQuantity();
}

</script>

<template>
    <div class="cart_item">
        <div class="d-flex">
            <img class="cart_item_img" :src="item.getCoverImageUrl()">
            <div class="ps-1">
                <div class="cart_item_title">{{item.getBookName()}}</div>
                <div> {{ item.getBookFormat() }}</div>
                <div class="cart_item_price">
                    <template v-if="item.getDiscount() > 0">
                        <div class="old_price">
                            {{item.getPrice()}}
                        </div>
                        <div>
                            {{ item.getPriceWithDiscount() }}
                        </div>
                    </template>
                    <template v-else>
                        {{item.getPrice()}}
                    </template>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-between">
            <a href="#" class="text-end" @click="cartStore.removeItem(item)">
                Remove
            </a>
            <div>
                <button class="me-2 btn btn-outline-dark" @click="decreaseQuantity">-</button>
                {{item.getQuantity()}}
                <button class="ms-2 btn btn-outline-dark" @click="increaseQuantity">+</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .cart_item {
        border-radius: 8px;
        border: 2px solid #a6a6a6;
        background-color: #fdfdfd;
        padding: 0.5rem;
        display: flex;
        justify-content: space-between;
    }
    .cart_item_title {
        font-weight: 500;
    }
    .cart_item_img {
        width: 3rem;
    }

    .old_price {
        text-decoration: line-through;
        color: red;
    }
</style>