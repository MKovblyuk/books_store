<script setup>
import {ref} from "vue";

const user = ref({
    "id": 13,
    "firstName": "TomCustomer",
    "lastName": "TomLast",
    "email": "customer@email.com",
    "role": "Customer",
    "phoneNumber": "232112"
});

</script>

<template>
    <section class="pt-2">
        <form class="profile_form">
            <div class="mb-3 fw-bold">{{user.firstName + " " + user.lastName}}</div>

            <div class="mb-3">
                <label for="firstName" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="firstName" :value="user.firstName">
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lastName" :value="user.lastName">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" :value="user.email">
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number:</label>
                <input type="tel" class="form-control" id="phoneNumber" :value="user.phoneNumber">
            </div>

            <button class="btn btn-primary me-1">
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
                                <label for="currentPassword" class="form-label">Current Password:</label>
                                <input type="password" class="form-control" id="currentPassword">
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New Password:</label>
                                <input type="password" class="form-control" id="newPassword">
                            </div>
                            <div class="mb-3">
                                <label for="newPasswordConfirmation" class="form-label">Confirm New Password:</label>
                                <input type="password" class="form-control" id="newPasswordConfirmation">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save new password</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<style scoped>
    .profile_form {
        margin: 0 auto;
        width: 50%;
    }
</style>