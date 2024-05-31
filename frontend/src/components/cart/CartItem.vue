<script setup>
const props = defineProps(['item']);
</script>

<template>
    <div class="cart_item">
        <div class="d-flex">
            <img class="cart_item_img" src="https://img.freepik.com/free-photo/painting-mountain-lake-with-mountain-background_188544-9126.jpg">
            <div class="ps-1">
                <div class="cart_item_title">{{item.name}}</div>
                <div class="cart_item_price">
                    <template v-if="item.discount > 0">
                        <div class="old_price">
                            {{item.price}}
                        </div>
                        <div v-if="item.discount > 0">
                            {{(item.price * item.discount).toFixed(2)}}
                        </div>
                    </template>
                    <template v-else>
                        {{item.price}}
                    </template>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-between">
            <a href="#" class="text-end">
                Remove
            </a>
            <div>
                <button class="me-2 btn btn-outline-dark">-</button>
                {{item.quantity}}
                <button class="ms-2 btn btn-outline-dark">+</button>
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