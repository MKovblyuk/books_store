<script setup>

import BookPreview from "@/components/books/BookPreview.vue";
import BookDetails from "@/components/books/BookDetails.vue";
import InlineBookList from "@/components/books/InlineBookList.vue";
import ReviewsSection from "@/components/reviews/ReviewsSection.vue";
import {ref} from "vue";
import BookCard from "@/components/books/BookCard.vue";

const book = ref({
    "id": 5,
    "name": "Modi fuga omnis qui.",
    "description": "Expedita at non quis iure omnis atque. Natus blanditiis et aperiam nihil at sequi quo. Dignissimos qui accusantium nihil ab minus quo eum. Ut exercitationem ea sed quis.",
    "publicationYear": "2005",
    "language": "French",
    "coverImageUrl": "https://via.placeholder.com/640x480.png/00aa22?text=et",
    "publishedAt": "2005-10-28 22:06:40",
    "audioFormat": {
        "id": 1,
        "price": "453.01",
        "discount": "9.57",
        "duration": 881
    },
    "electronicFormat": {
        "id": 3,
        "price": "442.68",
        "discount": "5.16",
        "pageCount": 107
    },
    "paperFormat": {
        "id": 5,
        "price": "333.19",
        "discount": "4.19",
        "quantity": 162,
        "pageCount": 673
    },
    "publisher": {
        "id": 5,
        "name": "Heidenreich Group"
    },
    "category": {
        "id": 13,
        "name": "history",
        "parentId": 1,
        "children": [
            {
                "id": 14,
                "name": "military history",
                "parentId": 13,
                "children": []
            },
            {
                "id": 15,
                "name": "world history",
                "parentId": 13,
                "children": []
            }
        ]
    },
    "authors": [
        {
            "id": 4,
            "firstName": "Elda",
            "lastName": "Lemke",
            "description": "Nihil mollitia ab architecto qui facere perferendis et. Hic dolores maxime iure id quas. Ut unde voluptatum corporis odio sit et perspiciatis.",
            "photoUrl": "https://via.placeholder.com/640x480.png/0099bb?text=beatae"
        },
        {
            "id": 9,
            "firstName": "Ruby",
            "lastName": "Lynch",
            "description": "Inventore maxime maxime doloremque beatae laborum aut. Optio qui harum est excepturi debitis. Esse ducimus ea et minus quas quas modi. Deleniti aut maxime assumenda ex quia minus.",
            "photoUrl": "https://via.placeholder.com/640x480.png/0000ff?text=adipisci"
        }
    ]
});

</script>

<template>
    <div>
        <div class="d-flex p-2">
            <BookPreview class="book_preview px-2" :coverImageUrl="book.coverImageUrl"/>
            <BookDetails class="book_details px-5" :book/>
        </div>
        <div class="p-2">
            <h6>Related Books</h6>
            <InlineBookList/>
        </div>

        <ReviewsSection class="mt-4"/>
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