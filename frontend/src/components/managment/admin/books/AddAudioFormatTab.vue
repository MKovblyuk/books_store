<script setup>
import UIFileInput from '@/components/ui/form_components/UIFileInput.vue';
import UIInput from '@/components/ui/form_components/UIInput.vue';
import UIErrorsList from '@/components/ui/sections/UIErrorsList.vue';
import { useEditBookFormat } from '@/composables/editBookFormat';
import { ref } from 'vue';

const props = defineProps(['bookId']);
const emit = defineEmits(['formatCreated']);
const audioFormat = ref({
    price: '',
    discount: 0,
    duration: '',
    'files[]': [],
})
const validationErrors = ref([]);
const {errors, storeFormat} = useEditBookFormat(props.bookId, 'audio');

function create()
{
    validationErrors.value = validateFormat();

    if (Object.keys(validationErrors.value).length === 0) {
        storeFormat(audioFormat.value).then(() => emit('formatCreated'));
    } 
}

function validateFormat() {
    const validationErrors = {};

    if (!audioFormat.value.price) {
        validationErrors.priceErrors = 'Price required';
    }
    if (!audioFormat.value.duration) {
        validationErrors.durationErrors = 'Duration required';
    }
    if (audioFormat.value['files[]'].length === 0) {
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
            v-model="audioFormat.price"
            :error-message="validationErrors.priceErrors"
        />
        <UIInput
            input-id="discountInput"
            label-title="Discount"
            type="number"
            class="mb-3"
            v-model="audioFormat.discount"
        />
        <UIInput
            input-id="pageCountInput"
            label-title="Duration"
            type="number"
            class="mb-3"
            v-model="audioFormat.duration"
            :error-message="validationErrors.durationErrors"
        />
        <UIFileInput
            input-id="elfileInput"
            @change="e => audioFormat['files[]'] = e.target.files"
            :error-message="validationErrors.filesErrors"
            class="mb-3"
        />
        <button class="btn btn-success" @click="create">
            Create
        </button>
    </div>
</template>