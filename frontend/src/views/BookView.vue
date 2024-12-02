<script setup>

import BookPreview from "@/components/books/BookPreview.vue";
import BookDetails from "@/components/books/BookDetails.vue";
import InlineBookList from "@/components/books/InlineBookList.vue";
import ReviewsSection from "@/components/reviews/ReviewsSection.vue";
import {useBookStore} from "@/stores/bookStore.js";
import {useRouter} from "vue-router";
import {useReviewStore} from "@/stores/reviewStore.js";
import { useCartStore } from "@/stores/cartStore";
import { CartItem } from "@/models/CartItem";
import { computed, ref, watch } from "vue";
import { useBook } from "@/composables/book";
import { useUserStore } from "@/stores/userStore";
import AddReviewForm from "@/components/reviews/AddReviewForm.vue";
import { BookFormats } from "@/enums/bookFormats";

const bookStore = useBookStore();
const reviewStore = useReviewStore();
const cartStore = useCartStore();
const userStore = useUserStore();

const router = useRouter();
const REVIEWS_PER_PAGE = 2;
const RELATED_BOOKS_PER_PAGE = 10;

const selectedFormat = ref();
const props = defineProps(['id']);
const canBuy = computed(() => selectedFormat.value !== BookFormats.Paper || bookStore.book?.paperFormat?.quantity > 0);

watch(() => props.id, fetchData, { immediate: true});

async function fetchData(book_id)
{
    bookStore.fetchBook(book_id).then(() => selectedFormat.value = useBook(bookStore.book).getAvailableFormat());
    await bookStore.fetchRelatedBooks(book_id, 1, RELATED_BOOKS_PER_PAGE);
    await reviewStore.fetchReviews(book_id, 1, REVIEWS_PER_PAGE);
}

function bookCardClickHandler(book_id)
{
    router.push('/book/' + book_id);
    selectedFormat.value = null;
}

async function reviewPageChangedHandler(page) 
{
    await reviewStore.fetchReviews(props.id, page, REVIEWS_PER_PAGE);
}

function addToCart() 
{
    if (canBuy.value) {
        try {
            const cartItem = new CartItem(bookStore.book, selectedFormat.value);
            cartStore.addItem(cartItem);
        } catch (e) {
            console.log(e);
        }
    }
}

function buy()
{
    if (canBuy.value) {
        addToCart();
        router.push('/order');
    }
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
                :selectedFormat="selectedFormat ?? useBook(bookStore.book).getAvailableFormat()"
                @change_selected_format="format => selectedFormat = format"
            />
        </div>
        <div class="p-2">
            <h6>Related Books</h6>
            <InlineBookList 
                :books="bookStore.relatedBooks" 
                @book_card_click="bookCardClickHandler"
            />
        </div>

        <ReviewsSection 
            class="mt-4" 
            :reviews="reviewStore.reviews" 
            :meta="reviewStore.meta"
            @page_changed="reviewPageChangedHandler"
        />

        <AddReviewForm 
            v-if="userStore.authorized"
            :bookId="id"
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