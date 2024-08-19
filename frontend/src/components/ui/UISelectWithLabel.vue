<script setup>
import UISelect from './UISelect.vue';

const props = defineProps(['id', 'items', 'defaultTitle', 'labelText', 'required', 'disabled']);

</script>

<template>
    <div>
        <label :for="id">
            {{ labelText }} <span v-if="required" class="required_asterisk">*</span>
        </label>
        <UISelect 
            :id
            :items
            :default-title="defaultTitle"
            :disabled
        />
    </div>

</template>

<style scoped>
    .required_asterisk {
        color: red;
    }
</style>