<script setup>
const props = defineProps(['review']);
</script>

<template>
    <div class="review_list_item p-2">
        <div class="review_header d-flex justify-content-between">
            <div>
                <div>{{ props.review.userFirstName + ' ' + props.review.userLastName }}</div>
                <div>{{props.review.updatedAt}}</div>
            </div>
            <div>
                Rating: {{props.review.rating}}
            </div>
        </div>

        <div class="review_body mt-2">
            {{props.review.review}}
        </div>
    </div>
</template>

<style scoped>
    .review_list_item{
        background-color: #eceaff;
        border-radius: 8px;
    }
</style>