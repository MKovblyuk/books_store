<script setup>
import CartItem from "@/components/cart/CartItem.vue";
import { useEasyPayCheckoutPopup } from "@/composables/easyPayCheckoutPopup";
import { useCartStore } from "@/stores/cartStore";
import axios from "axios";
import { onMounted, watch } from "vue";
import { ref } from "vue";
import UISelectWithLabel from "@/components/ui/UISelectWithLabel.vue";
import router from "@/router";
import { useUserStore } from "@/stores/userStore";

const cartStore = useCartStore();
const userStore = useUserStore();

let uponReceivingMethodId;
const paymentMethodId = ref();
const paymentMethods = ref([]);

const countries = ref([]);
const regions = ref([]);
const districts = ref([]);
const settlements = ref([]);
const addressId = ref();

const firstName = ref();
const lastName = ref();
const phoneNumber = ref();
const email = ref();

const easyPayCheckoutPopup = useEasyPayCheckoutPopup();

const errors = ref({});

onMounted(() => {
    fetchPaymentMethods();
    fetchCountries();
});

watch(easyPayCheckoutPopup.errors, value => errors.value = value);
watch(easyPayCheckoutPopup.successfulPaymentInteraction, isSuccessful => isSuccessful && closeOrderView());
 
async function fetchCountries() {
    const response = await axios.get('/countries');
    countries.value = response.data.data;
}

async function fetchRegions(countryId)
{
    const response = await axios.get('/regions?fields[regions]=id,name&filter[country_id]=' + countryId);
    regions.value = response.data.data;
}

async function fetchDistricts(regionId)
{
    const response = await axios.get('/districts?fields[districts]=id,name&filter[region_id]=' + regionId);
    districts.value = response.data.data;
}

async function fetchSettlements(districtId)
{
    const response = await axios.get('/addresses?filter[district_id]=' + districtId);
    settlements.value = response.data.data.map(item => ({...item, name: item.settlementName}));
}

async function fetchPaymentMethods()
{
    const response = await axios.get('/paymentMethods');
    paymentMethods.value = response.data;
    uponReceivingMethodId = paymentMethods.value.find( method => method.name === 'Upon Receiving').id;
}

function getPaymentData()
{
    const details = cartStore.items.map(item => ({
        'bookId': item.bookId,
        'bookFormat': item.bookFormat,
        'quantity': item.quantity
    }));

    let paymentData = {
        "addressId": 2,
        "shippingMethodId": 2,
        "paymentMethodId": paymentMethodId.value,
        "details": details
    }

    if (!userStore.authorized) {
        paymentData.guestDetails = {
            "firstName": firstName.value,
            "lastName": lastName.value,
            "phoneNumber": phoneNumber.value,
            "email": email.value
        }
    }

    return paymentData;
}

function createOrder()
{
    if (cartStore.items.length === 0) {
        alert('Cart is empty');
        return;
    }
 
    if (paymentMethods.value.findIndex(item => item.id == paymentMethodId.value) < 0) {
        alert('Select payment method');
        return;
    }

    if (addressId.value == undefined || addressId.value == '') {
        alert('Select address');
        return;
    }

    if (paymentMethodId.value == uponReceivingMethodId) {
        createUponReceivingOrder();
    } else {
        easyPayCheckoutPopup.createOnlinePaymentOrder(getPaymentData());
    }
}

async function createUponReceivingOrder()
{
    try {
        await axios.post('/orders', getPaymentData());
        closeOrderView();
    } catch (e) {
        errors.value = e.response.data.errors;
    }
}

function closeOrderView() 
{
    alert('Order successfully created!');
    router.push('home');
    cartStore.$reset();
}

</script>

<template>
    <div class="p-3">
        <RouterLink to="home" class="btn btn-outline-primary">Home</RouterLink>
        <div class="d-flex mt-4">
            <form class="order_contacts">
                <h5>Placing an order</h5>

                <section class="mt-3" v-if="!userStore.authorized">
                    <hr/>
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

                <hr/>
                <section class="mt-3">
                    <h6>Order data</h6>

                    <div class="row mt-3">
                        <div class="col-6">
                            <UISelectWithLabel
                                id="country_select"
                                default-title="Select Country"
                                :items="countries"
                                label-text="Country"
                                required="true"
                                @change="e => e.target.value != '' && fetchRegions(e.target.value)"
                            />
                        </div>
                        <div class="col-6">
                            <UISelectWithLabel
                                id="region_select"
                                default-title="Select Region"
                                :items="regions"
                                label-text="Region"
                                required="true"
                                @change="e => e.target.value != '' && fetchDistricts(e.target.value)"
                            />
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <UISelectWithLabel
                                id="district_select"
                                default-title="Select District"
                                :items="districts"
                                label-text="Distrit"
                                required="true"
                                @change="e => e.target.value != '' && fetchSettlements(e.target.value)"
                            />
                        </div>
                        <div class="col-6">
                            <UISelectWithLabel
                                id="settlement_select"
                                default-title="Select Settlement"
                                :items="settlements"
                                label-text="Settlement"
                                required="true"
                                @change="e => e.target.value != '' & (addressId = e.target.value)"
                            />
                        </div>
                    </div>
                </section>

                <hr/>
                <section class="mt-3">
                    <h6>
                        Payment Methods <span class="required_asteriks">*</span>
                    </h6>
                    <div>
                        <template v-for="method in paymentMethods" :key="method.id">
                            <input 
                                type="radio" 
                                :id="'payment_method_' + method.id" 
                                name="payment_method" 
                                :value="method.id"
                                @change="e => paymentMethodId = e.target.value"
                                class="me-2"
                            >
                            <label :for="'payment_method_' + method.id">{{method.name}}</label><br>
                        </template>
                    </div>
                </section>
            </form>

            <div class="order_details">
                <h6>Cart</h6>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        All {{cartStore.items.length}}
                    </div>
                </div>

                <div class="cart_items_list">
                    <CartItem v-for="item in cartStore.items" :item class="mt-2"/>
                </div>

                <div class="mt-3">
                    <div>Total Price {{ cartStore.totalPrice }}</div>
                    <button class="btn btn-success w-100" @click="createOrder">Accept</button>
                </div>
            </div>
        </div>


    </div>
</template>

<style scoped>
    .order_contacts {
        padding: 0.5rem;
        background-color: #f5f5f5;
        border-radius: 8px;
        width: 75%;
    }

    .order_details {
        width: 25%;
        padding: 0.5rem 1rem;
        background-color: #f5f5f5;
        border-radius: 8px;
        margin-left: 0.5rem;
    }

    .cart_items_list {
        height: 50vh;
        overflow-x: hidden;
        margin-top: 0.5rem;
    }

    .required_asteriks {
        color: red;
    }

    .error_message {
        color: rgb(248, 47, 47);
    }
</style>