<script setup>

const model = defineModel();

</script>

<template>
    <div>
        <button class="btn btn-outline-secondary me-1" @click="model--">
            <
        </button>
        <button class="btn btn-outline-secondary">
            {{ model }}
        </button>
        <button class="btn btn-outline-secondary ms-1" @click="model++">
            >
        </button>
    </div>
</template>