<script setup>
import UIInput from '@/components/ui/form_components/UIInput.vue';
import EditFilesSection from './EditFilesSection.vue';
import { useEditBookFormat } from '@/composables/editBookFormat';
import { useEditBookFormatFiles } from '@/composables/editBookFormatFiles';
import UIErrorsList from '@/components/ui/sections/UIErrorsList.vue';
import AddAudioFormatTab from './AddAudioFormatTab.vue';
import { onMounted, ref } from 'vue';
import { useAudioBook } from '@/composables/audioBook';
import ShowModal from '@/components/widgets/modals/ShowModal.vue';
import AudioPlayer from '@/components/widgets/AudioPlayer.vue';
import * as bootstrap from 'bootstrap';

const props = defineProps(['bookId']);
const validationErrors = ref([]);
const audioModalRef = ref(null);
const audioPlayerRef = ref(null);

const {
    errors, 
    formatData,
    formatNotFound, 
    updateFormat, 
    fetchFormat,
    deleteFormat
} = useEditBookFormat(props.bookId, 'audio', {
    price: '',
    discount: '',
    duration: '',
    files: []
});

const {fileErrors, uploadFile, deleteFile} = useEditBookFormatFiles(props.bookId, 'audio');
const {audioSrc ,openBook} = useAudioBook();

onMounted(() => {
    audioModalRef.value.modal.addEventListener('hidden.bs.modal', function () {
        audioPlayerRef.value.player.pause();
    });
});

function handelUpload(file) {
    uploadFile(file).then(() => fetchFormat());
}

function handleDelete(file) {
    deleteFile(file).then(() => fetchFormat());
}

function handleOpen(file) {
    openBook(props.bookId, file.extension)
        .then(() => bootstrap.Modal.getOrCreateInstance(audioModalRef.value.modal).show());
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
    if (!formatData.value.duration) {
        validationErrors.duration = 'Duration required';
    }

    return validationErrors;
}

</script>

<template>
    <AddAudioFormatTab 
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
        />
        <UIInput
            input-id="discountInput"
            label-title="Discount"
            type="number"
            class="mb-3"
            v-model="formatData.discount"
        />
        <UIInput
            input-id="durationInput"
            label-title="Duration"
            type="number"
            class="mb-3"
            v-model="formatData.duration"
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

        <ShowModal id="audioModalPlaer" ref="audioModalRef">
            <AudioPlayer :audioSrc ref="audioPlayerRef"/>
        </ShowModal>
    </div>
</template>