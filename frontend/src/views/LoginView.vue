<script setup>
import { useUserStore } from '@/stores/userStore';
import { ref } from 'vue';
import { useRouter } from 'vue-router';


const loginData = ref({
    email: '',
    password: '',
    remember: false
});

const errors = ref({
    email: [],
    password: [],
});

const userStore = useUserStore();
const router = useRouter();

const login = async () => {
    try {        
        await userStore.login(loginData.value);
        router.push('home');
    } catch(e) {
        if (e.response.status === 422) {
            errors.value = e.response.data.errors;
        }
        if (e.response.status === 400) {
            errors.value.password = [e.response.data.message, ...errors.value.password];
        }
        else {
            console.log('Error in login', e);
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
                            <RouterLink to="/register">Sign Up</RouterLink>
                        </div>
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
                        <form>
                            <div>
                                <span class="error_message" v-if="errors.email">
                                    {{ errors.email[0] }}
                                </span>
                                <div class="form-floating mb-3">
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="floatingInput" 
                                        placeholder="name@example.com"
                                        v-model="loginData.email"
                                    >
                                    <label for="floatingInput">Email address</label>
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
                                        id="floatingPassword" 
                                        placeholder="Password"
                                        v-model="loginData.password"
                                    >
                                    <label for="floatingPassword">Password</label>
                                </div>
                            </div>
    
                            <div class="form-check mb-3">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    id="rememberPasswordCheck"
                                    v-model="loginData.remember"
                                >
                                <label class="form-check-label" for="rememberPasswordCheck">
                                    Remember me
                                </label>
                            </div>
                            <div class="d-grid">
                                <button 
                                    class="btn btn-primary btn-login text-uppercase fw-bold" 
                                    type="submit"
                                    @click.prevent="login"
                                >
                                    Sign in
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