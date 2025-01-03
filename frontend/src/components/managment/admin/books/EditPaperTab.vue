<script setup>
import UIInput from '@/components/ui/form_components/UIInput.vue';
import UIErrorsList from '@/components/ui/sections/UIErrorsList.vue';
import { useEditBookFormat } from '@/composables/editBookFormat';
import { ref } from 'vue';
import AddPaperFormatTab from './AddPaperFormatTab.vue';

const props = defineProps(['bookId']);
const validationErrors = ref({});

const {
    errors,
    formatData,
    formatNotFound,
    fetchFormat,
    updateFormat,
    deleteFormat
} = useEditBookFormat(props.bookId, 'paper', {
    price: '',
    discount: 0,
    quantity: '',
    pageCount: '',
});

function update() {
    validationErrors.value = validateBookData();

    if (Object.keys(validationErrors.value).length === 0) {
        updateFormat().then(() => fetchFormat());
    } 
}

function validateBookData() {
    const validationErrors = {};

    if (!formatData.value.price) {
        validationErrors.priceErrors = 'Price required';
    }
    if (!formatData.value.pageCount) {
        validationErrors.pageCountErrors = 'Page count required';
    }
    if (!formatData.value.quantity) {
        validationErrors.quantityErrors = 'Quantity required';
    }

    return validationErrors;
}

</script>

<template>
    <AddPaperFormatTab 
        v-if="formatNotFound"
        :book-id="bookId"
        @format-created="fetchFormat"
    />
    <div v-else class="pt-3">
        <UIErrorsList
            class="mb-1 mt-3"
            :errors
        />

        <UIInput
            input-id="priceInput"
            label-title="Price"
            type="number"
            class="mb-3"
            v-model="formatData.price"
            :error-message="validationErrors.priceErrors"
        />
        <UIInput
            input-id="discountInput"
            label-title="Discount"
            type="number"
            class="mb-3"
            v-model="formatData.discount"
            :error-message="validationErrors.discountErrors"
        />
        <UIInput
            input-id="quantityInput"
            label-title="Quantity"
            type="number"
            class="mb-3"
            v-model="formatData.quantity"
            :error-message="validationErrors.quantityErrors"
        />        
        <UIInput
            input-id="pageCountInput"
            label-title="Page count"
            type="number"
            class="mb-3"
            v-model="formatData.pageCount"
            :error-message="validationErrors.pageCountErrors"
        />
        <button class="btn btn-success" @click="update">
            Update
        </button>
        <br>
        <button class="btn btn-danger mt-3" @click="deleteFormat">
            Delete Format
        </button>
    </div>
</template>