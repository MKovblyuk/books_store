<script setup>
import { ref } from 'vue';

const emit = defineEmits(['filterChanged']);

const searchPublisherData = ref({});

function reset() {
    searchPublisherData.value = {};
    emit('filterChanged', searchPublisherData.value);
}

</script>

<template>
    <div>
        <div class="mb-3">
            <label for="nameInput" class="form-label">
                Name
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="nameInput"
                v-model="searchPublisherData.name"
            >
        </div>
        <div>
            <button class="btn btn-primary me-1" @click="reset">
                Reset
            </button>
            <button class="btn btn-primary" @click="emit('filterChanged', searchPublisherData)">
                Search
            </button>
        </div>
    </div>
</template>