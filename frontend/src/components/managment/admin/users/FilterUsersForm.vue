<script setup>
import { ref } from 'vue';

const emit = defineEmits(['filterChanged']);

const searchUserData = ref({
    roles: []
});

function reset() {
    searchUserData.value = {
        roles: []
    };

    emit('filterChanged', searchUserData.value);
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
                v-model="searchUserData.firstName"
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
                v-model="searchUserData.lastName"
            >
        </div>
        <div class="mb-3">
            <label for="emailInput" class="form-label">
                Email address
            </label>
            <input 
                type="email" 
                class="form-control" 
                id="emailInput" 
                v-model="searchUserData.email"
            >
        </div>
        <div class="mb-3">
            <label for="phoneNumberInput" class="form-label">
                Phone number
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="phoneNumberInput"
                v-model="searchUserData.phoneNumber"
            >
        </div>
        <div class="mb-3">
            <label for="roleSelect" class="form-label">
                Role
            </label>
            <div class="d-flex">
                <div class="me-2">
                    <input type="checkbox" id="admin_check" value="Admin" v-model="searchUserData.roles" />
                    <label for="admin_check" class="ms-1">Admin</label>
                </div>
                <div class="me-2">
                    <input type="checkbox" id="editor_check" value="Editor" v-model="searchUserData.roles" />
                    <label for="editor_check" class="ms-1">Editor</label>
                </div>
                <div class="me-2">
                    <input type="checkbox" id="customer_check" value="Customer" v-model="searchUserData.roles" />
                    <label for="customer_check" class="ms-1">Customer</label>
                </div>
                <div>
                    <input type="checkbox" id="guest_check" value="Guest" v-model="searchUserData.roles" />
                    <label for="guest_check" class="ms-1">Guest</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="createdAtInput" class="form-label">
                Created At
            </label>
            <input 
                type="date" 
                class="form-control" 
                id="createdAtInput"
                v-model="searchUserData.createdAt"
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
                v-model="searchUserData.updatedAt"
            >
        </div>
        <div>
            <button class="btn btn-primary me-1" @click="reset">
                Reset
            </button>
            <button class="btn btn-primary" @click="emit('filterChanged', searchUserData)">
                Search
            </button>
        </div>
    </div>
</template>