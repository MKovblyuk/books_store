<script setup>
import { ref } from 'vue';

const props = defineProps(['audioSrc', 'imageSrc']);
const player = ref(null);

defineExpose({player});

</script>

<template>
    <div class="audio-body">
        <img :src="imageSrc" class="w-50 h-50 mb-2"/>
        <audio controls v-if="audioSrc" ref="player">
            <source :src=audioSrc type="audio/mpeg">
        </audio>
    </div>
</template>

<style>
    .audio-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 0.5rem;
        background-color: rgb(170, 236, 185);
    }
</style>