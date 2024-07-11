<script setup>

const props = defineProps(['book']);

const read = () => {
    console.log('read book');
}

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
                <button class="btn btn-success card-btn" @click.stop="read">Read</button>
            </div>
        </div>
    </div>
</template>