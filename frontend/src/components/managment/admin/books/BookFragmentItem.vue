<script setup>

const props = defineProps(['fragment', 'width', 'height']);
const emit = defineEmits(['delete', 'open']);

// change on bootstrap card item class
</script>

<template>
    <div>
        <img 
            :src="fragment.url" 
            :alt="`fragment_${fragment.id}`"
            :width="width ?? '200px'"
            :height="height ?? '200px'"
        >
        <div class="mt-2 w-100">
            <button class="btn btn-danger w-50" @click="emit('delete', fragment)">
                Delete
            </button>
            <button class="btn btn-success w-50" @click="emit('open', fragment)">
                Open
            </button>
        </div>
    </div>
</template>