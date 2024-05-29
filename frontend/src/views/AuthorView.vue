<script setup>

import {ref} from "vue";
import InlineBookList from "@/components/books/InlineBookList.vue";

const author = ref({
    "id": 10,
    "firstName": "Jorge",
    "lastName": "Lebsack",
    "description": "Voluptatem eaque dolorem asperiores est vel id voluptatem. Omnis quia enim nobis et ipsa velit. Non voluptates sunt vel id aspernatur blanditiis voluptates.",
    "photoUrl": "https://via.placeholder.com/640x480.png/004422?text=libero"
});

</script>

<template>
    <div>
        <div class="p-2 d-flex">
            <div class="photo">
                <img :src="author.photoUrl" class="w-100" alt="author"/>
            </div>
            <div class="content">
                <div>
                    {{author.firstName + " " + author.lastName}}
                </div>
                <div>
                    {{author.description}}
                </div>
            </div>
        </div>
        <div class="p-2 mt-3">
            <h6>Author's Books</h6>
            <InlineBookList/>
        </div>
    </div>
</template>

<style scoped>
    .photo {
        width: 15%;
    }
    .content {
        width: 85%;
        padding: 0 1rem;
    }
</style>