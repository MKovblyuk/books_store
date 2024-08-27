<script setup>
import { useBook } from "@/composables/book";
import { CartItem } from "@/models/CartItem";
import { useCartStore } from "@/stores/cartStore";
import { useFilterStore } from "@/stores/filterStore";
import { ref } from "vue";
import { useRouter } from 'vue-router'


const props = defineProps(['book']);

const cartStore = useCartStore();
const router = useRouter();
const {options} = useFilterStore();
const {getAvailableFormat, getFormatData} = useBook(props.book);

const selectedFormat= ref(options.formats[0] ?? getAvailableFormat());
const selectedFormatData = ref(getFormatData(selectedFormat.value));


function addToCart() 
{
    const cartItem = new CartItem(props.book, selectedFormat.value);
    cartStore.addItem(cartItem);
}

function buy()
{
    addToCart();
    router.push('/order');
}

</script>

<template>
    <div class="card" style="width: 14rem;">
        <img 
            :src="book.coverImageUrl" 
            class="card-img-top" 
            alt="..."
        >
        <div class="p-3 d-flex flex-column justify-content-between h-100">
            <h5 class="card-title">{{book.name}}</h5>
            <div v-if="selectedFormatData.discount > 0">
                <p class="text-decoration-line-through" >{{selectedFormatData.price}}</p>
                <p>{{selectedFormatData.price - (selectedFormatData.price * selectedFormatData.discount / 100)}}</p>
            </div>
            <div v-else>
                <p>{{selectedFormatData.price}}</p>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-danger card-btn" @click.stop="addToCart">To Cart</button>
                <button class="btn btn-success card-btn" @click.stop="buy">Buy</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.card {
    font-size: 14px;
    height: 20rem;
}

.card-btn {
    width: 48%;
}
.card:hover{
    cursor: pointer;
}

.card-img-top{
    height: 200px;
}

</style>