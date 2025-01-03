<script setup>
import PaginationBar from '@/components/widgets/PaginationBar.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import ReviewsTable from '@/components/managment/admin/reviews/ReviewsTable.vue';
import DeleteReviewModal from '@/components/widgets/modals/DeleteReviewModal.vue';

const deleteModalRef = ref();

const reviews = ref([]);
const meta = ref();
const selectedReview = ref();

const PER_PAGE = 8;
const sortParam = ref();

onMounted(() => {
    fetchReviews();
})

async function fetchReviews(page = 1) {
    const response = await axios.get('/reviews', {
        params: {
            page: page,
            per_page: PER_PAGE,
            sort: sortParam.value,
            include: 'book'
        }
    });

    reviews.value = response.data.data;
    meta.value = response.data.meta;
}

function sortingChangedHandler(isAsc, column) {
    sortParam.value = (isAsc ? '-' : '') + column;
    fetchReviews();
}

function showDeleteReviewModal(author) {
    selectedReview.value = author;
    deleteModalRef.value.click();
}

</script>

<template>
    <div>
        <ReviewsTable
            :reviews
            @sorting-changed="sortingChangedHandler"
            @delete-btn-clicked="showDeleteReviewModal"
        />

        <PaginationBar 
            v-if="meta"
            :meta
            @page_changed="newPage => fetchReviews(newPage)"
        />

        <button 
            hidden 
            data-bs-toggle="modal" 
            data-bs-target="#deleteModal"
            ref="deleteModalRef"
        ></button>
        <DeleteReviewModal 
            title="Delete review" 
            ok-btn-text="Delete" 
            id="deleteModal"
            :review="selectedReview"
            @review-deleted="fetchReviews"
        />
    </div>
</template>

<style scoped>
@media screen and (max-width:1400px) {
    table {
        font-size: 0.6rem !important;
    }
}
</style>