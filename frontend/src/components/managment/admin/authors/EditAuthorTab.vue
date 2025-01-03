<script setup>
import axios from 'axios';
import { ref, watchEffect } from 'vue';

const props = defineProps(['author']);
const emit = defineEmits(['authorUpdated', 'tryReturn']);

const errors = ref();
const authorUpdated = ref(false);

const newAuthorData = ref();

// maybe change on onUpdate
watchEffect(() => newAuthorData.value = {...props.author});


async function updateAuthor() {
    try {
        const response = await axios.patch('authors/' + props.author.id, newAuthorData.value);

        if (response.status === 200) {
            authorUpdated.value = true;
            alert('Author updated');
            emit('authorUpdated');
        }
    } catch(e) {
        if (e.response.status === 422) {
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
            <button class="btn btn-primary" @click="updateAuthor">Update</button>
        </div>
    </div>
</template>