<script setup>
import CartItem from "@/components/cart/CartItem.vue";
import { useEasyPayCheckoutPopup } from "@/composables/easyPayCheckoutPopup";
import { useCartStore } from "@/stores/cartStore";
import axios from "axios";
import { computed, onMounted, watch } from "vue";
import { ref } from "vue";
import router from "@/router";
import { useUserStore } from "@/stores/userStore";
import { BookFormats } from "@/enums/bookFormats";
import DeliveryPlaceSelects from "@/components/orders/DeliveryPlaceSelects.vue";
import PaymentMethodsSelects from "@/components/orders/PaymentMethodsSelects.vue";
import ContactDataSection from "@/components/orders/ContactDataSection.vue";

const cartStore = useCartStore();
const userStore = useUserStore();

let uponReceivingMethodId;
const paymentMethodId = ref();
const deliveryPlaceId = ref();

const guestDetails = ref({
    firstName: '',
    lastName: '',
    phoneNumber: '',
    email: '',
});

const easyPayCheckoutPopup = useEasyPayCheckoutPopup();

const errors = ref({});
const isDeliveryPlaceRequired = computed(() => cartStore.items.some(item => item.bookFormat === BookFormats.Paper));

onMounted(() => {
    assignUponReceivingMethodId();
});

watch(easyPayCheckoutPopup.errors, value => {
    errors.value = value

    if (value.details) {
        alert(value.details);
    }
});
watch(easyPayCheckoutPopup.successfulPaymentInteraction, isSuccessful => isSuccessful && closeOrderView());

async function assignUponReceivingMethodId()
{
    const response = await axios.get('/paymentMethods?filter[method]=UponReceiving');
    uponReceivingMethodId = response.data.data[0].id;
}

function getPaymentData()
{
    const details = cartStore.items.map(item => ({
        'bookId': item.bookId,
        'bookFormat': item.bookFormat,
        'quantity': item.quantity
    }));

    let paymentData = {
        "paymentMethodId": paymentMethodId.value,
        "deliveryPlaceId": deliveryPlaceId.value,
        "details": details
    }

    if (!userStore.authorized) {
        paymentData.guestDetails = guestDetails.value;
    }

    return paymentData;
}

function createOrder()
{
    if (cartStore.items.length === 0) {
        alert('Cart is empty');
        return;
    }
 
    if (paymentMethodId.value == undefined || paymentMethodId.value == '') {
        alert('Select payment method');
        return;
    }

    if (isDeliveryPlaceRequired.value && (deliveryPlaceId.value == undefined || deliveryPlaceId.value == '')) {
        alert('Select delivery place');
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
                <hr/>
                <ContactDataSection 
                    v-if="!userStore.authorized"
                    class="mt-3"
                    v-model:first-name="guestDetails.firstName"
                    v-model:last-name="guestDetails.lastName"
                    v-model:phone-number="guestDetails.phoneNumber"
                    v-model:email="guestDetails.email"
                    :errors
                />

                <hr/>
                <section class="mt-3">
                    <h6>Order data</h6>
                    <DeliveryPlaceSelects 
                        v-if="isDeliveryPlaceRequired"
                        @delivery_place_id_changed="value => deliveryPlaceId = value"
                    />
                </section>

                <hr/>
                <section class="mt-3">
                    <h6>
                        Payment Methods <span class="required_asteriks">*</span>
                    </h6>
                    <PaymentMethodsSelects 
                        @payment_method_id_changed="value => paymentMethodId = value"
                    />
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