<script setup>
import { ref } from 'vue';
import UIFileInput from './UIFileInput.vue';

const props = defineProps([
    'inputId', 'labelTitle', 'errorMessage', 'required', 'btnText',
    'width', 'height'
]);
const emit = defineEmits(['change']);
const imageRef = ref();
const showImage = ref(false);

function handleChange(e) {
    const file = e.target.files[0];

    if (file && file.type.startsWith('image/')) {
        const blob = new Blob([file], { type: file.type });
        imageRef.value.src = URL.createObjectURL(blob);
        showImage.value = true;
    } else {
        imageRef.value.src = '';
    }

    emit('change', e);
}

</script>

<template>
    <div>
        <img v-show="showImage"
            alt="selected_image" 
            ref="imageRef"
            :width="width ?? '200px'"
            :height="height ?? '200px'"
            @error="showImage = false"
            class="mb-1"
        />
        <UIFileInput
            :input-id="inputId"
            :label-title="labelTitle"
            :error-message="errorMessage"
            :btn-text="btnText"
            :required
            @change="handleChange"
        />
    </div>
</template>