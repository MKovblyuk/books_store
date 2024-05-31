<script setup>

</script>

<template>
<div class="back">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <div class="d-flex justify-content-between mb-3">
                            <RouterLink to="/">Back</RouterLink>
                            <RouterLink to="/login">Sign In</RouterLink>
                        </div>
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Sign Up</h5>
                        <form>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="first_name" placeholder="First Name">
                                <label for="first_name">First name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="last_name" placeholder="Last Name">
                                <label for="last_name">Last name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                                <label for="email">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="phone_number" placeholder="Phone number">
                                <label for="phone_number">Phone number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="passwordConfirmation" placeholder="Password Confirmation">
                                <label for="passwordConfirmation">Password Confirmation</label>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">
                                    Sign up
                                </button>
                            </div>
                            <hr class="my-4">
                            <div class="d-grid mb-2">
                                <button class="btn btn-google btn-login text-uppercase fw-bold" type="submit">
                                    <i class="fab fa-google me-2"></i> Sign up with Google
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