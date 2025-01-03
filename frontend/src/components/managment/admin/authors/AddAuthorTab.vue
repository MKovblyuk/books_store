<script setup>
import axios from 'axios';
import { ref } from 'vue';

const emit = defineEmits(['authorCreated', 'tryReturn']);

const errors = ref();
const newAuthorData = ref({});

async function createAuthor() {
    try {
        const response = await axios.post('authors', newAuthorData.value);

        if (response.status === 201) {
            alert('Author created');
            emit('authorCreated');
        }
    } catch(e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
}

</script>

<template>
    <div>
        <div>
            <button class="btn btn-success" @click="emit('tryReturn')">
                &lArr;
            </button>
        </div>
        <div>
            <div class="mb-3">
                <label for="firstNameInput" class="form-label">
                    First name
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="firstNameInput"
                    v-model="newAuthorData.firstName"
                >
                <div class="text-danger">{{ errors?.first_name?.[0] }}</div>
            </div>
            <div class="mb-3">
                <label for="lastNameInput" class="form-label">
                    Last name
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="lastNameInput"
                    v-model="newAuthorData.lastName"
                >
                <div class="text-danger">{{ errors?.last_name?.[0] }}</div>
            </div>
            <div class="mb-3">
                <label for="descriptionInput" class="form-label">
                    Description
                </label>
                <textarea
                    type="text" 
                    class="form-control" 
                    id="descriptionInput"
                    v-model="newAuthorData.description"
                ></textarea>
                <div class="text-danger">{{ errors?.description?.[0] }}</div>
            </div>
        </div>
        <div class="p-1">
            <button class="btn btn-primary me-1" @click="emit('tryReturn')">Cancel</button>
            <button class="btn btn-primary" @click="createAuthor">Create</button>
        </div>
    </div>
</template>