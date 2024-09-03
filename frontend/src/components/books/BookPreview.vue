<script setup>

import Carousel from "@/components/widgets/Carousel.vue";
import { useDefaultAssests } from "@/composables/defaultAssets";
import { useBookStore } from "@/stores/bookStore";

const bookStore = useBookStore();
const { defaultImageSrc } = useDefaultAssests();

</script>

<template>
    <div>
        <button class="btn btn-outline-primary mb-2">Like</button>
        <img
            :src="bookStore.book.coverImageUrl"
            class="w-100 mb-2"
            alt="book_preview_image"
            @error="e => e.target.src = defaultImageSrc"
        >
        <button 
            type="button" 
            class="btn btn-success w-100 mb-2" 
            data-bs-toggle="modal" 
            data-bs-target="#staticBackdrop"
        >
            Preview
        </button>

        <button 
            type="button" 
            class="btn btn-primary w-100 mb-2" 
            @click="$emit('to_cart')"
        >
            To Cart
        </button>
        <button 
            type="button" 
            class="btn btn-primary w-100 mb-2" 
            @click="$emit('buy')"
        >
            Buy
        </button>

        <div class="modal fade" id="staticBackdrop"  tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <Carousel 
                            :image-urls="bookStore.book?.fragments?.map(item => item.url)"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>