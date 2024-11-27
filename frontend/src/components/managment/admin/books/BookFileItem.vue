<script setup>

const props = defineProps(['file']);
const emit = defineEmits(['delete', 'open']);

</script>

<template>
    <div class="book_file_item">
        <div class="p-2">
            <div>File: {{ file?.dirName }}</div>
            <div>Size: {{ file?.size }}</div>
            <div>Extension: {{ file?.extension }}</div>
        </div>
        <div class="mt-2 w-100">
            <button class="btn btn-danger w-50" @click="emit('delete', file)">
                Delete
            </button>
            <button class="btn btn-success w-50" @click="emit('open', file)">
                Open
            </button>
        </div>
    </div>
</template>

<style scoped>
.book_file_item {
    background-color: white;
    border: 2px rgb(89, 89, 89) solid;
    border-radius: 8px;
}
</style>