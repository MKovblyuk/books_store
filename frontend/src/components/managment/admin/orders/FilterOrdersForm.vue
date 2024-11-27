<script setup>
import { ref } from 'vue';

const emit = defineEmits(['filterChanged']);

const searchOrderData = ref({
    user: {}
});

function reset() {
    searchOrderData.value = {
        user: {}
    };

    emit('filterChanged', searchOrderData.value);
}

</script>

<template>
    <div>
        <div class="mb-3">
            <label for="firstNameInput" class="form-label">
                Id
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="firstNameInput"
                v-model="searchOrderData.id"
            >
        </div>
        <div class="mb-3">
            <label for="emailInput" class="form-label">
                User's email address
            </label>
            <input 
                type="email" 
                class="form-control" 
                id="emailInput" 
                v-model="searchOrderData.user.email"
            >
        </div>
        <div class="mb-3">
            <label for="phoneNumberInput" class="form-label">
                User's phone number
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="phoneNumberInput"
                v-model="searchOrderData.user.phoneNumber"
            >
        </div>
        <div class="mb-3">
            <label for="createdAtInput" class="form-label">
                Created At
            </label>
            <input 
                type="date" 
                class="form-control" 
                id="createdAtInput"
                v-model="searchOrderData.createdAt"
            >
        </div>
        <div class="mb-3">
            <label for="updatedAtInput" class="form-label">
                Updated At
            </label>
            <input 
                type="date" 
                class="form-control" 
                id="updatedAtInput"
                v-model="searchOrderData.updatedAt"
            >
        </div>
        <div>
            <button class="btn btn-primary me-1" @click="reset">
                Reset
            </button>
            <button class="btn btn-primary" @click="emit('filterChanged', searchOrderData)">
                Search
            </button>
        </div>
    </div>
</template>