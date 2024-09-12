<script setup>
import { useReviewStore } from '@/stores/reviewStore';
import axios from 'axios';
import { ref } from 'vue';
import RatingBar from './RatingBar.vue';

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
        <div class="p-2">
            <RatingBar v-model="rating"/>

            <div class="form-floating mt-2">
                <textarea 
                    class="form-control" 
                    placeholder="Leave a comment here" 
                    id="floatingTextarea"
                    v-model="review"
                ></textarea>
                <label for="floatingTextarea">Add Review</label>
            </div>
    
            <button 
                class="btn btn-primary mt-1"
                @click="addReviewHandler"
            >
                Add Review
            </button>
        </div>
</template>