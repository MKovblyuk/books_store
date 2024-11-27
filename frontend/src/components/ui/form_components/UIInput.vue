<script setup>

const model = defineModel();
const props = defineProps(['inputId', 'labelTitle', 'errorMessage', 'type', 'required']);

</script>

<template>
    <div>
        <label :for="inputId" class="form-label">
            {{ labelTitle }}
        </label>
        <input 
            :type="type ?? 'text'" 
            class="form-control" 
            :id="inputId"
            v-model="model"
            :required
        >
        <div class="text-danger">{{ errorMessage }}</div>
    </div>
</template>