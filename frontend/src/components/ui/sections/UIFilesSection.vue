<script setup>
import UIFileInput from '@/components/ui/form_components/UIFileInput.vue';
import { ref } from 'vue';

const props = defineProps(['files', 'addBtnText']);
const emit = defineEmits(['upload']);
const newFile = ref();

function uploadFile() {
    if (newFile.value) {
        emit('upload', newFile.value);
    }
}

</script>

<template>
    <div>
        <div class="file_section">
            <slot></slot>
        </div>
        <UIFileInput 
            input-id="newAudioFileInput"
            @change="e => newFile = e.target.files[0]"
            class="mt-1"
        />
        <button class="btn btn-success mt-1" @click="uploadFile">
            {{ addBtnText ?? 'Add' }}
        </button>

    </div>
</template>

<style scoped>
.file_section {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    padding: 1rem;
    background-color: rgb(223, 225, 255);
    border-radius: 8px;
}
</style>