<script setup>
import axios from 'axios';
import { ref } from 'vue';

const emit = defineEmits(['publisherCreated', 'tryReturn']);

const errors = ref();
const newPublisherData = ref({});

async function createPublisher() {
    try {
        const response = await axios.post('publishers', newPublisherData.value);

        if (response.status === 201) {
            alert('Publisher created');
            emit('publisherCreated');
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
                <label for="nameInput" class="form-label">
                    Name
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="nameInput"
                    v-model="newPublisherData.name"
                >
                <div class="text-danger">{{ errors?.name?.[0] }}</div>
            </div>
        </div>
        <div class="p-1">
            <button class="btn btn-primary me-1" @click="emit('tryReturn')">Cancel</button>
            <button class="btn btn-primary" @click="createPublisher">Create</button>
        </div>
    </div>
</template>