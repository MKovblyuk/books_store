<script setup>
import { useReviewStore } from '@/stores/reviewStore';
import axios from 'axios';
import { ref } from 'vue';

const review = ref('');
const rating = ref(1);
const reviewStore = useReviewStore();
const props = defineProps(['bookId'])

function addReviewHandler() {
    axios.post('/reviews', {
        'bookId': props.bookId,
        'review': review.value,
        'rating': rating.value,
    }).then(() => {
        reviewStore.fetchReviews(props.bookId);
    }).catch(error => {
        console.log('error in adding review:', error);
    });

    review.value = '';
}



</script>

<template>
        <div class="form-floating p-2">
            <textarea 
                class="form-control" 
                placeholder="Leave a comment here" 
                id="floatingTextarea"
                v-model="review"
            ></textarea>
            <label for="floatingTextarea">Add Review</label>

            <button 
                class="btn btn-primary mt-1"
                @click="addReviewHandler"
            >
                Add Review
            </button>
        </div>
</template>