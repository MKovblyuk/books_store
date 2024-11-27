<script setup>
import axios from 'axios';
import { ref, watchEffect } from 'vue';

const props = defineProps(['user']);
const emit = defineEmits(['userUpdated', 'tryReturn']);

const errors = ref();
const userUpdated = ref(false);

const newUserData = ref();

// maybe change on onUpdate
watchEffect(() => newUserData.value = {...props.user});

// update user by put method create additional route

async function updateUser() {
    try {
        const response = await axios.patch('users/' + props.user.id, newUserData.value);

        if (response.status === 200) {
            userUpdated.value = true;
            alert('User updated');
            emit('userUpdated');
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
                    v-model="newUserData.firstName"
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
                    v-model="newUserData.lastName"
                >
                <div class="text-danger">{{ errors?.last_name?.[0] }}</div>
            </div>
            <div class="mb-3">
                <label for="emailInput" class="form-label">
                    Email address
                </label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="emailInput" 
                    v-model="newUserData.email"
                >
                <div class="text-danger">{{ errors?.email?.[0] }}</div>
            </div>
            <div class="mb-3">
                <label for="phoneNumberInput" class="form-label">
                    Phone number
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="phoneNumberInput"
                    v-model="newUserData.phoneNumber"
                >
                <div class="text-danger">{{ errors?.phone_number?.[0] }}</div>
            </div>
            <div class="mb-3">
                <label for="roleSelect" class="form-label">
                    Role
                </label>
                <select class="form-select" id="roleSelect" v-model="newUserData.role">
                    <option value="Admin">Admin</option>
                    <option value="Editor">Editor</option>
                    <option value="Customer">Customer</option>
                    <option value="Guest">Guest</option>
                </select>
            </div>
        </div>
        <div class="p-1">
            <button class="btn btn-primary me-1" @click="emit('tryReturn')">Cancel</button>
            <button class="btn btn-primary" @click="updateUser">Update</button>
        </div>
    </div>
</template>