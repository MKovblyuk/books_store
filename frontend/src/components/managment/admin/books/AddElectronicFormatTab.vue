<script setup>
import UIFileInput from '@/components/ui/form_components/UIFileInput.vue';
import UIInput from '@/components/ui/form_components/UIInput.vue';
import UIErrorsList from '@/components/ui/sections/UIErrorsList.vue';
import { useEditBookFormat } from '@/composables/editBookFormat';
import { ref } from 'vue';

const props = defineProps(['bookId']);
const emit = defineEmits(['formatCreated']);
const electronicFormat = ref({
    price: '',
    discount: 0,
    pageCount: '',
    'files[]': [],
})
const validationErrors = ref([]);
const {errors, storeFormat} = useEditBookFormat(props.bookId, 'electronic');

function create()
{
    validationErrors.value = validateFormat();

    if (Object.keys(validationErrors.value).length === 0) {
        storeFormat(electronicFormat.value).then(() => emit('formatCreated'));
    } 
}

function validateFormat() {
    const validationErrors = {};

    if (!electronicFormat.value.price) {
        validationErrors.priceErrors = 'Price required';
    }
    if (!electronicFormat.value.pageCount) {
        validationErrors.pageCountErrors = 'Page count required';
    }
    if (electronicFormat.value['files[]'].length === 0) {
        validationErrors.filesErrors = 'Files required';
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
            v-model="electronicFormat.price"
            :error-message="validationErrors.priceErrors"
        />
        <UIInput
            input-id="discountInput"
            label-title="Discount"
            type="number"
            class="mb-3"
            v-model="electronicFormat.discount"
        />
        <UIInput
            input-id="pageCountInput"
            label-title="Page count"
            type="number"
            class="mb-3"
            v-model="electronicFormat.pageCount"
            :error-message="validationErrors.pageCountErrors"
        />
        <UIFileInput
            input-id="audiofileInput"
            @change="e => electronicFormat['files[]'] = e.target.files"
            :error-message="validationErrors.filesErrors"
            class="mb-3"
        />
        <button class="btn btn-success" @click="create">
            Create
        </button>
    </div>
</template>