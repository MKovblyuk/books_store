<script setup>

import ReviewList from "@/components/reviews/ReviewList.vue";
import {ref} from "vue";
import PaginationBar from "@/components/PaginationBar.vue";

const reviews = ref([
    {
        "id": 10,
        "rating": 3,
        "review": "Qui maxime magnam dolorum et quae necessitatibus exercitationem. Non a et quia. Sequi aperiam est ut. Aspernatur voluptate nemo ut illum sit cupiditate doloribus.",
        "userId": 2,
        "bookId": 6,
        "updatedAt": "2024-05-07T09:52:04.000000Z"
    },
    {
        "id": 9,
        "rating": 4,
        "review": "Ut commodi id modi qui animi. Aspernatur cum autem voluptatem maiores dolor earum. Dolorem illo ipsam velit perferendis vel natus.",
        "userId": 7,
        "bookId": 6,
        "updatedAt": "2024-05-07T09:52:04.000000Z"
    },
    {
        "id": 8,
        "rating": 1,
        "review": "Est repudiandae at est optio. Autem temporibus ut illo quidem consectetur est dicta.",
        "userId": 4,
        "bookId": 2,
        "updatedAt": "2024-05-07T09:52:04.000000Z"
    },
    {
        "id": 7,
        "rating": 1,
        "review": "Facere sequi aperiam officiis quam amet vel. Unde ipsa mollitia ea porro voluptas.",
        "userId": 10,
        "bookId": 3,
        "updatedAt": "2024-05-07T09:52:03.000000Z"
    },
    {
        "id": 6,
        "rating": 2,
        "review": "Quidem voluptatem et ad facilis nihil aut doloribus. Ab eaque sapiente voluptatum. Voluptas et ut vero ipsa cumque totam maxime.",
        "userId": 6,
        "bookId": 4,
        "updatedAt": "2024-05-07T09:52:03.000000Z"
    },
    {
        "id": 5,
        "rating": 3,
        "review": "Animi soluta quo commodi doloremque hic architecto. Quia sit beatae eos et perspiciatis odit. Voluptas est porro quae perspiciatis minus. Et ipsam ut et consequuntur officiis consequatur.",
        "userId": 5,
        "bookId": 3,
        "updatedAt": "2024-05-07T09:52:03.000000Z"
    },
    {
        "id": 4,
        "rating": 5,
        "review": "Minima voluptas excepturi et sit nam et totam. Iusto et deserunt omnis vitae. Amet quis voluptatibus qui magnam. Aspernatur neque soluta ex aut.",
        "userId": 10,
        "bookId": 5,
        "updatedAt": "2024-05-07T09:52:03.000000Z"
    },
    {
        "id": 3,
        "rating": 3,
        "review": "Aut voluptatem accusantium placeat aut voluptas sapiente optio. Corrupti maiores rerum natus. Dolore quaerat itaque assumenda deleniti sit iure. Nobis enim aliquam enim repellat similique.",
        "userId": 9,
        "bookId": 2,
        "updatedAt": "2024-05-07T09:52:03.000000Z"
    },
    {
        "id": 2,
        "rating": 2,
        "review": "Repellendus accusantium pariatur velit laboriosam. Culpa aut unde vero nostrum vero omnis exercitationem. Debitis id explicabo voluptate qui quod architecto qui id.",
        "userId": 6,
        "bookId": 5,
        "updatedAt": "2024-05-07T09:52:03.000000Z"
    },
    {
        "id": 1,
        "rating": 3,
        "review": "Deleniti voluptas voluptatem quod. Vel porro officiis esse in debitis impedit. Et vel eos ut ut.",
        "userId": 2,
        "bookId": 5,
        "updatedAt": "2024-05-07T09:52:03.000000Z"
    }
]);
</script>

<template>
    <div class="p-2">
        <h6 class="mb-2">Reviews</h6>

        <ReviewList :reviews/>
        <PaginationBar/>
    </div>
</template>

<style scoped>

</style>