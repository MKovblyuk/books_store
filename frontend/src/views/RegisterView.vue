<script setup>
import { useUserStore } from '@/stores/userStore';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';


const firstName = ref();
const lastName = ref();
const email = ref();
const phoneNumber = ref();
const password = ref();
const passwordConfirmation = ref();

const errors = ref({
    firstName: [],
    lastName: [],
    email: [],
    phoneNumber: [],
    password: [],
    passwordConfirmation: [],
});

const userStore = useUserStore();
const router = useRouter();

const register = async () => {
    const data = {
        firstName: firstName.value,
        lastName: lastName.value,
        email: email.value,
        phoneNumber: phoneNumber.value,
        password: password.value,
        passwordConfirmation: passwordConfirmation.value
    };

    try {
        const response = await axios.post('http://localhost/api/register', data);
        userStore.setToken(response.data.token);
        router.push('home');
    } catch (e){
        if (e.response.status == 422) {
            console.log(e.response);
            errors.value = {
                firstName: e.response.data.errors.first_name,
                lastName: e.response.data.errors.last_name,
                email: e.response.data.errors.email,
                phoneNumber: e.response.data.errors.phone_number,
                password: e.response.data.errors.password,
                passwordConfirmation: e.response.data.errors.password_confirmation
            }
        }
    }
}

</script>

<template>
<div class="back">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <div class="d-flex justify-content-between mb-3">
                            <RouterLink to="home">Home</RouterLink>
                            <RouterLink to="/login">Sign In</RouterLink>
                        </div>
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Sign Up</h5>
                        <form>
                            <div>
                                <span class="error_message" v-if="errors.firstName">
                                    {{ errors.firstName[0] }}
                                </span>
                                <div class="form-floating mb-3">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="first_name" 
                                        placeholder="First Name" 
                                        required
                                        v-model="firstName"
                                    >
                                    <label for="first_name">First name</label>
                                </div>
                            </div>
                            <div>
                                <span class="error_message" v-if="errors.lastName">
                                    {{ errors.lastName[0] }}
                                </span>
                                <div class="form-floating mb-3">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="last_name" 
                                        placeholder="Last Name" 
                                        required
                                        v-model="lastName"
                                    >
                                    <label for="last_name">Last name</label>
                                </div>
                            </div>
                            <div>
                                <span class="error_message" v-if="errors.email">
                                    {{ errors.email[0] }}
                                </span>
                                <div class="form-floating mb-3">
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="email" 
                                        placeholder="name@example.com" 
                                        required
                                        v-model="email"
                                    >
                                    <label for="email">Email address</label>
                                </div>
                            </div>
                            <div>
                                <span class="error_message" v-if="errors.phoneNumber">
                                    {{ errors.phoneNumber[0] }}
                                </span>
                                <div class="form-floating mb-3">
                                    <input 
                                        type="tel" 
                                        class="form-control" 
                                        id="phone_number" 
                                        placeholder="Phone number"
                                        v-model="phoneNumber"
                                    >
                                    <label for="phone_number">Phone number</label>
                                </div>
                            </div>
                            <div>
                                <span class="error_message" v-if="errors.password">
                                    {{ errors.password[0] }}
                                </span>
                                <div class="form-floating mb-3">
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="password" 
                                        placeholder="Password"
                                        required
                                        v-model="password"
                                    >
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div>
                                <span class="error_message" v-if="errors.passwordConfirmation">
                                    {{ errors.passwordConfirmation[0] }}
                                </span>
                                <div class="form-floating mb-3">
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="passwordConfirmation" 
                                        placeholder="Password Confirmation"
                                        required
                                        v-model="passwordConfirmation"
                                    >
                                    <label for="passwordConfirmation">Password Confirmation</label>
                                </div>
                            </div>
      
                            <div class="d-grid">
                                <button 
                                    class="btn btn-primary btn-login text-uppercase fw-bold" 
                                    type="submit"
                                    @click.prevent="register"
                                >
                                    Sign up
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>

@import "@/assets/forms/auth.css";

</style>