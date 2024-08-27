<script setup>

import BookPreview from "@/components/books/BookPreview.vue";
import BookDetails from "@/components/books/BookDetails.vue";
import InlineBookList from "@/components/books/InlineBookList.vue";
import ReviewsSection from "@/components/reviews/ReviewsSection.vue";
import {onMounted, ref} from "vue";
import {useBookStore} from "@/stores/bookStore.js";
import {useRoute, useRouter} from "vue-router";
import {useReviewStore} from "@/stores/reviewStore.js";
import { useCartStore } from "@/stores/cartStore";
import { CartItem } from "@/models/CartItem";
import { useBook } from "@/composables/book";

const bookStore = useBookStore();
const reviewStore = useReviewStore();
const cartStore = useCartStore();

const route = useRoute();
const router = useRouter();

const reviews_per_page = 2;

const selectedFormat = ref();

onMounted( () => {
    fetchData(route.params.id).then(
        () => selectedFormat.value = useBook(bookStore.book).getAvailableFormat()
    );
});

const fetchData = async (book_id) => {
    await bookStore.fetchBook(book_id);
    await bookStore.fetchRelatedBooks();
    await reviewStore.fetchReviews(route.params.id, 1, reviews_per_page);
}

const book_card_click_handler = (book_id) => {
    router.push('/book/' + book_id);
    fetchData(book_id);
}

const review_page_changed_handler = async (page) => {
    await reviewStore.fetchReviews(route.params.id, page, reviews_per_page);
}

function addToCart() 
{
    const cartItem = new CartItem(bookStore.book, selectedFormat.value);
    cartStore.addItem(cartItem);
}

function buy()
{
    addToCart();
    router.push('/order');
}


</script>

<template>
    <div>
        <div class="d-flex p-2">
            <BookPreview 
                class="book_preview px-2" 
                @to_cart="addToCart"
                @buy="buy"
            />
            <BookDetails 
                v-if="bookStore.bookIsLoaded" 
                class="book_details px-5" 
                :book="bookStore.book"
                :selectedFormat
                @select_format="(format_name) => selectedFormat = format_name"
            />
        </div>
        <div class="p-2">
            <h6>Related Books</h6>
            <InlineBookList 
                :books="bookStore.relatedBooks" 
                @book_card_click="book_card_click_handler"
            />
        </div>

        <ReviewsSection 
            class="mt-4" 
            :reviews="reviewStore.reviews" 
            :meta="reviewStore.meta"
            @page_changed="review_page_changed_handler"
        />
    </div>
</template>

<style scoped>
    .book_preview {
        width: 15%;
    }
    .book_details {
        width: 85%;
    }
</style>