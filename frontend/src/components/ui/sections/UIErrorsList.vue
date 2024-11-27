<script setup>

const props = defineProps(['errors']);

</script>

<template>
    <div class="text-danger">
        <div v-for="error in errors">
            {{ error }}
        </div>
    </div>
</template>