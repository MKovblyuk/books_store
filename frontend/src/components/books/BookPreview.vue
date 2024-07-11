<script setup>

import Carousel from "@/components/widgets/Carousel.vue";

const props = defineProps(['coverImageUrl'])
const lastUrl = "https://img.freepik.com/free-photo/painting-mountain-lake-with-mountain-background_188544-9126.jpg";

</script>

<template>
    <div>
        <button class="btn btn-outline-primary mb-2">Like</button>
        <img
            :src="lastUrl"
            class="w-100 mb-2"
            alt="book_preview_image"
        >
        <button type="button" class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Preview
        </button>

        <button type="button" class="btn btn-primary w-100 mb-2" @click="$emit('to_cart')">
            To Cart
        </button>
        <button type="button" class="btn btn-primary w-100 mb-2" @click="$emit('buy')">
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
                        <Carousel/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>