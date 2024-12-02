<script setup>
import { useDefaultAssests } from '@/composables/defaultAssets';
import { BookFormats } from '@/enums/bookFormats';
import { useCartStore } from '@/stores/cartStore';

const props = defineProps(['item']);
const cartStore = useCartStore();

</script>

<template>
    <div class="cart_item">
        <div class="cart_item_left_block">
            <img 
                class="cart_item_img" 
                :src="item.getCoverImageUrl() ?? useDefaultAssests().defaultImageSrc"
                @error="e => e.target.src = useDefaultAssests().defaultImageSrc"
            >
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
            <div 
                v-if="item?.bookFormat === BookFormats.Paper"
                class="d-flex align-items-center justify-content-between"
            >
                <button class="btn btn-outline-dark" @click="item.decreaseQuantity">-</button>
                <div class="p-1"> {{item.getQuantity()}}</div>
                <button class="btn btn-outline-dark" @click="item.increaseQuantity">+</button>
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
    font-size: 12px;
}
.cart_item_title {
    font-weight: 500;
    width: 100%;
}
.cart_item_img {
    width: 30%;
}

.old_price {
    text-decoration: line-through;
    color: red;
}

.cart_item_left_block {
    width: 75%;
    overflow: hidden;
    display: flex;
}

</style>