<script setup>
import { useBook } from "@/composables/book";
import { CartItem } from "@/models/CartItem";
import { useCartStore } from "@/stores/cartStore";
import { computed, ref, watch } from "vue";
import { useRouter } from 'vue-router'
import BookCardFormatItem from "./BookCardFormatItem.vue";
import { BookFormats } from "@/enums/bookFormats";
import { usePriceCalculator } from "@/composables/priceCalculator";
import { useDefaultAssests } from "@/composables/defaultAssets";

const props = defineProps(['book']);

const cartStore = useCartStore();
const router = useRouter();
const { getAvailableFormat, getFormatData } = useBook(props.book);
const priceCalculator = usePriceCalculator();
const { defaultImageSrc } = useDefaultAssests();

const selectedFormat = ref(getAvailableFormat());
const formatData = computed(() => getFormatData(selectedFormat.value));

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
        <div class="d-flex justify-content-center">
            <img 
                :src="book.coverImageUrl" 
                class="card-img-top" 
                alt="not found image"
                @error="e => e.target.src = defaultImageSrc"
            >
        </div>

        <div class="p-3 d-flex flex-column justify-content-between h-100">
            <h5 class="card-title">{{book.name}}</h5>
            <div class="d-flex flex-column">
                <div 
                    class="btn-group mb-1"   
                    role="group" 
                    aria-label="Basic radio toggle button group"
                    @click.stop=""
                >
                    <template v-if="book.paperFormat">
                        <input 
                            type="radio" 
                            class="btn-check" 
                            name="btnradio" 
                            :id="'btnradio1' + book.id" 
                            autocomplete="off" 
                            :value="BookFormats.Paper"
                            v-model="selectedFormat"
                        >
                        <label 
                            class="btn btn-outline-primary btn-sm" 
                            :class="{active: (selectedFormat === BookFormats.Paper)}" 
                            :for="'btnradio1' + book.id"
                        >
                            <img v-if="selectedFormat === BookFormats.Paper" src="@/assets/icons/book-solid-white.svg" width="15rem"/>
                            <img v-else src="@/assets/icons/book-solid.svg" width="15rem">
                        </label>
                    </template>
                    
                    <template v-if="book.electronicFormat">
                        <input 
                            type="radio" 
                            class="btn-check" 
                            name="btnradio" 
                            :id="'btnradio2' + book.id" 
                            autocomplete="off"
                            :value="BookFormats.Electronic"
                            v-model="selectedFormat"
                        >
                        <label 
                            class="btn btn-outline-primary btn-sm" 
                            :class="{active: (selectedFormat === BookFormats.Electronic)}" 
                            :for="'btnradio2' + book.id"
                        >
                            <img v-if="selectedFormat === BookFormats.Electronic" src="@/assets/icons/file-solid-white.svg" width="12rem"/>
                            <img v-else src="@/assets/icons/file-solid.svg" width="12rem"/>
                        </label>
                    </template>

                    <template v-if="book.audioFormat">
                        <input 
                            type="radio" 
                            class="btn-check" 
                            name="btnradio" 
                            :id="'btnradio3' + book.id" 
                            autocomplete="off"
                            :value="BookFormats.Audio"
                            v-model="selectedFormat"
                        >
                        <label 
                            class="btn btn-outline-primary btn-sm" 
                            :class="{active: (selectedFormat === BookFormats.Audio)}" 
                            :for="'btnradio3' + book.id"
                        >
                            <img v-if="selectedFormat === BookFormats.Audio" src="@/assets/icons/volume-high-solid-white.svg" width="17rem"/>
                            <img v-else src="@/assets/icons/volume-high-solid.svg" width="17rem"/>
                        </label>
                    </template>
                </div>

                <BookCardFormatItem 
                    :new-price="formatData.discount > 0 ? priceCalculator.calculateToFixed(formatData.price, formatData.discount) : formatData.price"
                    :old-price="formatData.discount > 0 ? formatData.price : ''"
                    :format-name="selectedFormat"
                    class="card_format_item"
                />

                <div class="d-flex justify-content-between mt-2">
                    <button class="btn btn-danger card-btn" @click.stop="addToCart">To Cart</button>
                    <button class="btn btn-success card-btn" @click.stop="buy">Buy</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.card {
    font-size: 14px;
    height: 28rem;
}

.card-btn {
    width: 48%;
}
.card:hover {
    cursor: pointer;
}

.card-img-top {
    height: 225px;
    max-width: 100%
}

.card_format_item {
    height: 3rem;
}

.card-title {
    height: 3rem;
    overflow: hidden;
}

</style>