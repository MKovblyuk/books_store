<script setup>

import ReviewList from "@/components/reviews/ReviewList.vue";
import PaginationBar from "@/components/PaginationBar.vue";

const props = defineProps(['reviews' , 'meta']);

</script>

<template>
    <div class="p-2">
        <h6 class="mb-2">Reviews</h6>
        <ReviewList :reviews/>
        <PaginationBar 
            v-if="reviews.length > 0"
            :meta 
            @page_changed="(page) => $emit('page_changed',page)"
        />
    </div>
</template>

<style scoped>

</style>6