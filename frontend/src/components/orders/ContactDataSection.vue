<script setup>

const firstName = defineModel('firstName');
const lastName = defineModel('lastName');
const phoneNumber = defineModel('phoneNumber');
const email = defineModel('email');

const props = defineProps(['errors']);

</script>

<template>
    <section>
        <h6>Contact data</h6>

        <div class="row mt-3">
            <div class="col-6">
                <label for="first_name">
                    First name <span class="required_asteriks">*</span>
                </label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="First name"
                    aria-label="First name"
                    id="first_name"
                    required
                    v-model="firstName"
                >
                    <div 
                    v-if="errors['guestDetails.firstName']?.length > 0" 
                    class="error_message"
                >
                    Please choose a first name.
                </div>
            </div>
            <div class="col-6">
                <label for="last_name">
                    Last name <span class="required_asteriks">*</span>
                </label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Last name"
                    aria-label="Last name"
                    id="last_name"
                    required
                    v-model="lastName"
                >
                <div 
                    v-if="errors['guestDetails.lastName']?.length > 0" 
                    class="error_message"
                >
                    Please choose a last name.
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <label for="phone_number">
                    Phone number <span class="required_asteriks">*</span>
                </label>
                <input
                    type="tel"
                    class="form-control"
                    placeholder="Phone number"
                    aria-label="Phone number"
                    id="phone_number"
                    required
                    v-model="phoneNumber"
                    maxlength="10"
                >
                <div 
                    v-if="errors['guestDetails.phoneNumber']?.length > 0" 
                    class="error_message"
                >
                    Incorrect phone number.
                </div>
            </div>
            <div class="col-6">
                <label for="email">
                    Email <span class="required_asteriks">*</span>
                </label>
                <input
                    type="email"
                    class="form-control"
                    placeholder="Email"
                    aria-label="Email"
                    id="email"
                    required
                    v-model="email"
                >
                <div 
                    v-if="errors['guestDetails.email']?.length > 0" 
                    class="error_message"
                >
                    Incorrect email.
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
    .required_asteriks {
        color: red;
    }

    .error_message {
        color: rgb(248, 47, 47);
    }
</style>