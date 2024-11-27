<script setup>
import UIInput from '@/components/ui/form_components/UIInput.vue';
import { ref } from 'vue';
import EditFilesSection from './EditFilesSection.vue';
import { useEditBookFormat } from '@/composables/editBookFormat';
import { useEditBookFormatFiles } from '@/composables/editBookFormatFiles';
import UIErrorsList from '@/components/ui/sections/UIErrorsList.vue';
import AddElectronicFormatTab from './AddElectronicFormatTab.vue';
import { useElectronicBook } from '@/composables/electronicBook';

const props = defineProps(['bookId']);
const validationErrors = ref({});

const readLinkRef = ref(null);
const downloadLinkRef = ref(null);

const {
    errors, 
    formatData,
    formatNotFound, 
    updateFormat, 
    fetchFormat,
    deleteFormat
} = useEditBookFormat(props.bookId, 'electronic', {
    price: '',
    discount: '',
    pageCount: '',
    files: []
});

const {fileErrors, uploadFile, deleteFile} = useEditBookFormatFiles(props.bookId, 'electronic');
const {openLinkRef, openBook} = useElectronicBook();

function handleDelete(file) {
    deleteFile(file).then(() => fetchFormat());
}

function handelUpload(file) {
    uploadFile(file).then(() => fetchFormat());
}

function handleOpen(file) {
    openBook(props.bookId, file.extension);
}

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

    return validationErrors;
}

</script>

<template>
    <div>
        <AddElectronicFormatTab 
            v-if="formatNotFound" 
            :book-id="bookId"
            @format-created="fetchFormat"
        />
        <div v-else class="pt-3">
            <UIErrorsList
                :errors
                class="mb-1 mt-3"
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

            <UIErrorsList 
                :errors="fileErrors"
                class="mb-1 mt-3"
            />
            <EditFilesSection 
                :files="formatData.files"
                @delete="handleDelete"
                @upload="handelUpload"
                @open="handleOpen"
            />

            <button class="btn btn-danger mt-3" @click="deleteFormat">
                Delete Format
            </button>
            <a class="visually-hidden" ref="openLinkRef"></a>
            <a class="visually-hidden" ref="downloadLinkRef"></a>
        </div>
    </div>
</template>