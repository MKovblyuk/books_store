<script setup>

import Carousel from "@/components/widgets/Carousel.vue";
import { useDefaultAssests } from "@/composables/defaultAssets";
import { useNumberFormatter } from "@/composables/numberFormatter";
import { useBookStore } from "@/stores/bookStore";
import { useUserStore } from "@/stores/userStore";
import axios from "axios";
import { computed } from "vue";

const bookStore = useBookStore();
const userStore = useUserStore();
const { defaultImageSrc } = useDefaultAssests();
const { formatToString } = useNumberFormatter();

const isLikedByUser = computed(() => bookStore.book.likedUsersIds?.includes(userStore.user.id));

function likeBook() {
    axios.post('users/'+ userStore.user.id +'/like/' + bookStore.book.id);
    bookStore.book.likedUsersIds.push(userStore.user.id);
}

function unlikeBook() {
    axios.post('users/'+ userStore.user.id +'/unlike/' + bookStore.book.id);
    bookStore.book.likedUsersIds.splice(bookStore.book.likedUsersIds.indexOf(userStore.user.id),1);
}

</script>

<template>
    <div>
        <div class="d-flex justify-content-start align-items-center pb-2">
            <div>
                {{ formatToString(bookStore.book.likedUsersIds?.length) }}
            </div>
            <div 
                v-if="userStore.authorized"
                @click="isLikedByUser ? unlikeBook() : likeBook()"
            >
                <img 
                    v-if="isLikedByUser" 
                    src="@/assets/icons/heart-liked.svg" 
                    class="likeImg"
                >
                <img v-else 
                    src="@/assets/icons/heart-unliked.svg" 
                    class="likeImg"
                >
            </div>
        </div>

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

.likeImg {
    width: 1.2rem;
    height: 1.2rem;
    margin-left: 0.2rem;
}

.likeImg:hover {
    transform: scale(1.2);
}

</style>