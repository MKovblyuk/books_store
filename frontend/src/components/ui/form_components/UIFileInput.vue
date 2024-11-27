<script setup>

const props = defineProps([
    'inputId', 'labelTitle', 'errorMessage', 'required', 'btnText', 'multiple'
]);
const emit = defineEmits(['change']);

</script>

<template>
    <div>
        <label v-if="labelTitle" :for="inputId" class="form-label">
            {{ labelTitle }}
        </label>
        <div class="input-group custom-file-button">
            <label :for="inputId" class="input-group-text">
                {{ btnText ?? 'Choose file' }}
            </label>
            <input 
                type="file" 
                class="form-control" 
                :id="inputId"
                @change="e => emit('change', e)"
                :required
                :multiple
            >
        </div>
        <div class="text-danger">{{ errorMessage }}</div>
    </div>
</template>

<style scoped>

.custom-file-button input[type=file] {
  margin-left: -2px !important;
}

.custom-file-button input[type=file]::-webkit-file-upload-button {
  display: none;
}

.custom-file-button input[type=file]::file-selector-button {
  display: none;
}

.custom-file-button:hover label {
  background-color: #dde0e3;
  cursor: pointer;
}

</style>