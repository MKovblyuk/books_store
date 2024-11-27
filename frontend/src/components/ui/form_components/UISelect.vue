<script setup>

const props = defineProps([
    'selectId', 'items', 'labelText', 'required', 'errorMessage', 'multiple'
]);

const model = defineModel();

</script>

<template>
    <div>
        <label :for="selectId" class="form-label">
            {{ labelText }} <span v-if="required" class="text-danger">*</span>
        </label>
        <select 
            class="form-select" 
            :aria-label="selectId" 
            :id="selectId" 
            v-model="model"
            :multiple
        >
            <option 
                v-for="item in items" 
                :value="item.id"     
                :key="item.id"
            >
                {{ item.name }}
            </option>
        </select>
        <div class="text-danger">
            {{ errorMessage }}
        </div>
    </div>

</template>

<!-- <style scoped>
    .required_asterisk {
        color: red;
    }
</style> -->