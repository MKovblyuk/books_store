<script setup>

import ReviewListItem from "@/components/reviews/ReviewListItem.vue";

const props = defineProps(['reviews'])

</script>

<template>
    <div>
        <template v-for="review in props.reviews">
            <ReviewListItem :review class="mb-2"/>
        </template>
    </div>
</template>

<style scoped>

</style>