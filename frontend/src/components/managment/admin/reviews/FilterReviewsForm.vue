<script setup>
import { ref } from 'vue';

const emit = defineEmits(['filterChanged']);

const searchAuthorData = ref({});

function reset() {
    searchAuthorData.value = {};
    emit('filterChanged', searchAuthorData.value);
}

</script>

<template>
    <div>
        <div class="mb-3">
            <label for="firstNameInput" class="form-label">
                First name
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="firstNameInput"
                v-model="searchAuthorData.firstName"
            >
        </div>
        <div class="mb-3">
            <label for="lastNameInput" class="form-label">
                Last name
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="lastNameInput"
                v-model="searchAuthorData.lastName"
            >
        </div>
        <div>
            <button class="btn btn-primary me-1" @click="reset">
                Reset
            </button>
            <button class="btn btn-primary" @click="emit('filterChanged', searchAuthorData)">
                Search
            </button>
        </div>
    </div>
</template>