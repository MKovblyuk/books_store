<script setup>

import BookCharacteristicsList from "@/components/books/BookCharacteristicsList.vue";
import { useBook } from "@/composables/book";
import { usePriceCalculator } from "@/composables/priceCalculator";
import { BookFormats } from "@/enums/bookFormats";

const props = defineProps(['book', 'selectedFormat']);

const { getFormatData } = useBook(props.book);
const priceCalculator = usePriceCalculator();

const formatData = getFormatData(props.selectedFormat);

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
                <button 
                    v-if="book.paperFormat" 
                    :class="'btn btn-outline-primary me-1' + (selectedFormat===BookFormats.Paper ? ' active' : '')"
                    @click="$emit('change_selected_format', BookFormats.Paper)"
                >
                    Paper
                </button>
                <button 
                    v-if="book.electronicFormat" 
                    :class="'btn btn-outline-primary me-1' + (selectedFormat===BookFormats.Electronic ? ' active' : '')"
                    @click="$emit('change_selected_format', BookFormats.Electronic)"
                >
                    Electronic
                </button>
                <button 
                    v-if="book.audioFormat"
                    :class="'btn btn-outline-primary' + (selectedFormat===BookFormats.Audio ? ' active' : '')"
                    @click="$emit('change_selected_format', BookFormats.Audio)"
                >
                    Audio
                </button>
            </div>

            <div class="mt-2">
                <div class="text-decoration-line-through">
                    {{formatData.discount > 0 ? formatData.price : ''}}
                </div>
                <div>
                    {{formatData.discount > 0 ? priceCalculator.calculate(formatData.price, formatData.discount) : formatData.price }}
                </div>
            </div>
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

        <div v-if="selectedFormat===BookFormats.Paper" class="d-flex mt-2 paper_characteristic">
            <div>
                <div class="general_characteristic_item_title">Page Count</div>
                <div>{{book.paperFormat.pageCount}}</div>
            </div>
        </div>
        <div v-if="selectedFormat===BookFormats.Electronic" class="d-flex mt-2 electronic_characteristic">
            <div>
                <div class="general_characteristic_item_title">Page Count</div>
                <div>{{book.electronicFormat.pageCount}}</div>
            </div>
        </div>
        <div v-if="selectedFormat===BookFormats.Audio" class="d-flex mt-2 audio_characteristic">
            <div>
                <div class="general_characteristic_item_title">Duration</div>
                <div>{{book.audioFormat.duration}}</div>
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