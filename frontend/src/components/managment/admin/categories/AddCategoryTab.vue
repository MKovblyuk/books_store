<script setup>
import axios from 'axios';
import { ref } from 'vue';

const props = defineProps(['parentCategory']);
const emit = defineEmits(['categoryCreated', 'tryReturn']);

const errors = ref();
const newCategoryData = ref({});

function createCategory() {
    if (props.parentCategory) {
        createCategoryForParent(props.parentCategory);
    } else {
        createFirstLevelCategory();
    }
}

async function createCategoryForParent(parent) {
    try {
        const response = await axios.post('categories/' + parent.id, newCategoryData.value);

        if (response.status === 201) {
            alert('Category created');
            emit('categoryCreated');
        }
    } catch(e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
}

async function createFirstLevelCategory() {
    try {
        const response = await axios.post('categories', newCategoryData.value);

        if (response.status === 201) {
            alert('Category created');
            emit('categoryCreated');
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
                    v-model="newCategoryData.name"
                >
                <div class="text-danger">{{ errors?.name?.[0] }}</div>
            </div>
        </div>
        <div class="p-1">
            <button class="btn btn-primary me-1" @click="emit('tryReturn')">Cancel</button>
            <button class="btn btn-primary" @click="createCategory">Create</button>
        </div>
    </div>
</template>