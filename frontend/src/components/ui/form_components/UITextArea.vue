<script setup>

const model = defineModel();
const props = defineProps(['textAreaId', 'labelTitle', 'errorMessage', 'required']);

</script>

<template>
    <div>
        <label :for="textAreaId" class="form-label">
            {{ labelTitle }}
        </label>
        <textarea 
            class="form-control" 
            :id="textAreaId"
            v-model="model"
            :required
        ></textarea>
        <div class="text-danger">{{ errorMessage }}</div>
    </div>
</template>