<script setup>

const props = defineProps(['id', 'items', 'defaultTitle']);

</script>

<template>
    <select 
        class="form-select" 
        :aria-label="id" 
        :id="id" 
    >
        <option value='' selected>{{ defaultTitle }}</option>
        <option 
            v-for="item in items" 
            :value="item.id"     
            :key="item.id"
        >
            {{ item.name }}
        </option>
    </select>
</template>