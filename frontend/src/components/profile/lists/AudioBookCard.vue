<script setup>
import { BookExtensions } from '@/enums/bookExtensions';

const props = defineProps(['book']);
const emit = defineEmits(['listen', 'download']);

</script>

<template>
    <div class="card" style="width: 14rem;">
        <img 
            src="https://img.freepik.com/free-photo/painting-mountain-lake-with-mountain-background_188544-9126.jpg" 
            class="card-img-top" 
            alt="..."
        >
        <div class="p-3 d-flex flex-column justify-content-between h-100">
            <h5 class="card-title">{{book.name}}</h5>
            <div class="d-flex justify-content-between">
                <button class="btn btn-success card-btn" @click.stop="emit('listen', book, BookExtensions.MP3)">Listen</button>
                <button class="btn btn-primary card-btn" @click.stop="emit('download', book, BookExtensions.MP3)">Download</button>
            </div>
        </div>
    </div>
</template>