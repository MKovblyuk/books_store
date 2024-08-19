<script setup>
import CartItem from "@/components/cart/CartItem.vue";
import { useEasyPayCheckoutPopup } from "@/composables/easyPayCheckoutPopup";
import { useCartStore } from "@/stores/cartStore";
import axios from "axios";
import { onMounted } from "vue";
import { ref } from "vue";

const cartStore = useCartStore();

const paymentMethodId = ref();
const paymentMethods = ref([]);

// const paymentData = ref({
//     "addressId": '',
//     "shippingMethodId": '',
//     "paymentMethodId": '',
//     "details": ''
// });

let uponReceivingMethodId;

const easyPayCheckoutPopup = useEasyPayCheckoutPopup();

onMounted(async () => {
    const response = await axios.get('/paymentMethods');
    paymentMethods.value = response.data;
    uponReceivingMethodId = paymentMethods.value.find( method => method.name === 'Upon Receiving').id;
});

function getPaymentData()
{
    const details = cartStore.items.map(item => ({
        'bookId': item.bookId,
        'bookFormat': item.bookFormat,
        'quantity': item.quantity
    }));

    return {
        "addressId": 2,
        "shippingMethodId": 2,
        "paymentMethodId": paymentMethodId.value,
        "details": details
    };
}

function createOrder()
{
    if (cartStore.items.length === 0) {
        console.log('cart is empty');
        return;
    }

    if (paymentMethodId.value === undefined) {
        console.log('select payment method');
        return;
    }

    if (paymentMethodId === uponReceivingMethodId) {
        createUponReceivingOrder();
    } else {
        easyPayCheckoutPopup.createOnlinePaymentOrder(getPaymentData());
    }
}

async function createUponReceivingOrder()
{
    const response = await axios.post('/orders', getPaymentData());
    console.log(response);
}

</script>

<template>
    <div class="p-3">
        <RouterLink to="/1" class="btn btn-outline-primary">Home</RouterLink>
        <div class="d-flex mt-4">
            <form class="order_contacts">
                <h5>Placing an order</h5>

                <hr/>
                <section class="mt-3">
                    <h6>Contact data</h6>

                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="first_name">First name *</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="First name"
                                aria-label="First name"
                                id="first_name"
                                required
                            >
                        </div>
                        <div class="col-6">
                            <label for="last_name">Last name *</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Last name"
                                aria-label="Last name"
                                id="last_name"
                                required
                            >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="phone_number">Phone number *</label>
                            <input
                                type="tel"
                                class="form-control"
                                placeholder="Phone number"
                                aria-label="Phone number"
                                id="phone_number"
                                required
                            >
                        </div>
                        <div class="col-6">
                            <label for="email">Email *</label>
                            <input
                                type="email"
                                class="form-control"
                                placeholder="Email"
                                aria-label="Email"
                                id="email"
                                required
                            >
                        </div>
                    </div>
                </section>

                <hr/>
                <section class="mt-3">
                    <h6>Order data</h6>

                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="country_select">Country *</label>
                            <select class="form-select" aria-label="country_select" id="country_select">
                                <option value="1" selected>Ukraine</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="region_select">Region *</label>
                            <select class="form-select" aria-label="region_select" id="region_select">
                                <option selected>Select Region</option>
                                <option value="1">Lviv</option>
                                <option value="2">Kyiv</option>
                                <option value="3">Ivano-Frankivsk</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="district_select">District *</label>
                            <select class="form-select" aria-label="district_select" id="district_select">
                                <option selected>Select District</option>
                                <option value="1">Kolomuya</option>
                                <option value="2">Nadvirna</option>
                                <option value="3">Ivano-Frankivsk</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="settlement_select">Settlement *</label>
                            <select class="form-select" aria-label="settlement_select" id="settlement_select">
                                <option selected>Select Settlement Address</option>
                                <option value="1">Lviv</option>
                                <option value="2">Kyiv</option>
                                <option value="3">Ivano-Frankivsk</option>
                            </select>
                        </div>
                    </div>
                </section>

                <hr/>
                <section class="mt-3">
                    <h6>Payment Methods</h6>
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
</style>