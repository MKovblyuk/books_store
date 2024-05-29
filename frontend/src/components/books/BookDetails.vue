<script setup>

import BookCharacteristicsList from "@/components/books/BookCharacteristicsList.vue";

const props = defineProps(['book']);

let authors = '';
props.book.authors.forEach(author => authors+=author.firstName + " " + author.lastName + ", ");
authors = authors.substring(0, authors.length - 2);

</script>

<template>
    <div>
        <h3>{{props.book.name}}</h3>
        <h4>{{authors}}</h4>

        <div class="mt-2">
            <div>
                <button v-if="book.paperFormat" class="btn btn-outline-primary me-1 active">Paper</button>
                <button v-if="book.electronicFormat" class="btn btn-outline-primary me-1">Electronic</button>
                <button v-if="book.audioFormat" class="btn btn-outline-primary">Audio</button>
            </div>
            <div class="mt-2">Price</div>
        </div>

        <div class="d-flex mt-2">
            <div class="general_characteristic_item">
                <div class="general_characteristic_item_title">Language</div>
                <div>{{book.language}}</div>
            </div>
            <div class="general_characteristic_item">
                <div class="general_characteristic_item_title">Publisher</div>
                <div>{{book.publisher.name}}</div>
            </div>
            <div class="general_characteristic_item">
                <div class="general_characteristic_item_title">Producing Year</div>
                <div>{{book.publicationYear}}</div>
            </div>
        </div>

        <div class="mt-3">{{props.book.description}}</div>

        <BookCharacteristicsList/>

    </div>
</template>

<style scoped>
    .general_characteristic_item {
        background-color: #f4f4f4;
        margin-right: 1rem;
        padding: 0.5rem;
        border-radius: 8px;
        border: 2px solid #a6a6a6;
    }
    .general_characteristic_item_title {
        font-weight: 500;
    }
</style>