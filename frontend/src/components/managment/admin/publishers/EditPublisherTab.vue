<script setup>
import axios from 'axios';
import { ref, watchEffect } from 'vue';

const props = defineProps(['publisher']);
const emit = defineEmits(['publisherUpdated', 'tryReturn']);

const errors = ref();
const publisherUpdated = ref(false);

const newPublisherData = ref();

// maybe change on onUpdate
watchEffect(() => newPublisherData.value = {...props.publisher});


async function updatePublisher() {
    try {
        const response = await axios.patch('publishers/' + props.publisher.id, newPublisherData.value);

        if (response.status === 200) {
            publisherUpdated.value = true;
            alert('Publisher updated');
            emit('publisherUpdated');
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
            <button class="btn btn-primary" @click="updatePublisher">Update</button>
        </div>
    </div>
</template>