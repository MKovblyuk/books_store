<script setup>
import UIInput from '@/components/ui/form_components/UIInput.vue';
import UIErrorsList from '@/components/ui/sections/UIErrorsList.vue';
import { useEditBookFormat } from '@/composables/editBookFormat';
import { ref } from 'vue';

const props = defineProps(['bookId']);
const emit = defineEmits(['formatCreated']);
const paperFormat = ref({
    price: '',
    discount: 0,
    pageCount: '',
    quantity: '',
})
const validationErrors = ref([]);
const {errors, storeFormat} = useEditBookFormat(props.bookId, 'paper');

function create()
{
    validationErrors.value = validateFormat();

    if (Object.keys(validationErrors.value).length === 0) {
        storeFormat(paperFormat.value).then(() => emit('formatCreated'));
    } 
}

function validateFormat() {
    const validationErrors = {};

    if (!paperFormat.value.price) {
        validationErrors.priceErrors = 'Price required';
    }
    if (!paperFormat.value.pageCount) {
        validationErrors.pageCountErrors = 'Page count required';
    }
    if (!paperFormat.value.quantity) {
        validationErrors.quantityErrors = 'Quantity required';
    }

    return validationErrors;
}

</script>

<template>
    <div class="pt-3">
        <UIErrorsList
            :errors
            class="mb-1 mt-3"
        />

        <UIInput
            input-id="priceInput"
            label-title="Price"
            type="number"
            class="mb-3"
            v-model="paperFormat.price"
            :error-message="validationErrors.priceErrors"
        />
        <UIInput
            input-id="discountInput"
            label-title="Discount"
            type="number"
            class="mb-3"
            v-model="paperFormat.discount"
        />
        <UIInput
            input-id="pageCountInput"
            label-title="Page count"
            type="number"
            class="mb-3"
            v-model="paperFormat.pageCount"
            :error-message="validationErrors.pageCountErrors"
        />
        <UIInput
            input-id="quantityInput"
            label-title="Quantity"
            type="number"
            class="mb-3"
            v-model="paperFormat.quantity"
            :error-message="validationErrors.quantityErrors"
        />       
        <button class="btn btn-success" @click="create">
            Create
        </button>
    </div>
</template>