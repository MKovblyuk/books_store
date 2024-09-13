<script setup>

const props = defineProps(['categories']);
const emit = defineEmits(['category_changed']);

</script>

<template>
    <div class="p-2 d-flex bg-light">
        <button 
            v-for="category in categories" :key="category.id"
            class="btn btn-outline-success mx-1"
            @click="$emit('category_changed', category.id)"
        >
            {{ category.name }}
        </button>
    </div>
</template>