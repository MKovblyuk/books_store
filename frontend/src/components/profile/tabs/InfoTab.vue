<script setup>
import { useUserStore } from '@/stores/userStore';
import axios from 'axios';
import { ref } from 'vue';


const userStore = useUserStore();

const errors = ref({});
const passwordData = ref({
    "password": "",
    "passwordConfirmation": "",
});

const updatePassword = async () => {
    try {
        const response = await axios.patch('/users/' + userStore.user.id, passwordData.value);
        console.log(response);
    } catch(e) {
        if (e.response.status === 422) {
            errors.value = e.response.data.errors;
        }

        console.log('Errors in update password', e);
    }
}

const updateData = async () => {
    try {
        await axios.patch('/users/' + userStore.user.id, userStore.user);
    } catch(e) {
        if (e.response.status === 422) {
            errors.value = e.response.data.errors;
        }

        console.log('Errors in  update data', e);
    }
}

</script>

<template>
    <section class="pt-2">
        <form class="profile_form">
            <div class="mb-3 fw-bold">{{userStore.user.firstName + " " + userStore.user.lastName}}</div>

            <div class="mb-3">
                <label for="firstName" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="firstName" v-model="userStore.user.firstName">
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lastName" v-model="userStore.user.lastName">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" v-model="userStore.user.email">
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number:</label>
                <input type="tel" class="form-control" id="phoneNumber" v-model="userStore.user.phoneNumber">
            </div>

            <button class="btn btn-primary me-1" @click.prevent="updateData">
                Save
            </button>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Change Password
            </button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New Password:</label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="newPassword"
                                    v-model="passwordData.newPassword"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="newPasswordConfirmation" class="form-label">Confirm New Password:</label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="newPasswordConfirmation"
                                    v-model="passwordData.newPasswordConfirmation"
                                >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" @click="updatePassword">Save new password</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>