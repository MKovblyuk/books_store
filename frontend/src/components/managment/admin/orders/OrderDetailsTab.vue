<script setup>
import { useConfigStore } from '@/stores/configStore';
import axios from 'axios';
import { onMounted, ref } from 'vue';


const props = defineProps(['order']);
const emit = defineEmits(['tryReturn']);

const details = ref([]);
const address = ref();

async function fetchDetails() {
    const response = await axios.get('orders/' + props.order.id + '/details');

    if (response.status === 200) {
        details.value = response.data.data;
        details.value.forEach(async item => item.book = await fetchBookInfo(item.bookId));
    }
}

async function fetchBookInfo(bookId) {
    const response = await axios.get('books/' + bookId, {
        params: {
            'include': 'category,publisher'
        }
    });

    return response.data.data;
}

async function fetchAddress() {
    const response = await axios.get('deliveryPlaces/' + props.order.deliveryPlaceId + '/fullAddress');
    
    if (response.status === 200) {
        address.value = response.data.data;
    }
}

onMounted(() => {
    fetchDetails();
    fetchAddress();
});

</script>

<template>
    <div>
        <div>
            <button class="btn btn-success" @click="emit('tryReturn')">
                &lArr;
            </button>
        </div>
        <hr>
        <div class="mt-2 row">
            <div class="col">
                <div>ID: {{ order.id }}</div>
                <div>Status: {{ order.status}}</div>
                <div>Total price: {{ order.totalPrice }}</div>
                <div>
                    Created: {{ (new Date(order.createdAt)).toLocaleString(useConfigStore().locale, {hour12: false}) }}
                </div>
                <div>
                    Updated: {{ (new Date(order.updatedAt)).toLocaleString(useConfigStore().locale, {hour12: false}) }}
                </div>
            </div>
            <div class="col"> 
                <div>User id: {{ order.user.id }}</div>
                <div>User first name: {{ order.user.firstName }}</div>
                <div>User last name: {{ order.user.lastName }}</div>
                <div>Email: {{ order.user.email }}</div>
                <div>Phone: {{ order.user.phoneNumber }}</div>
            </div>
        </div>
        <hr>

        <div class="mt-2 row">
            <div class="col">
                <div>Address</div>
                <div>Street Address: {{ address?.streetAddress }}</div>
                <div>Settlement: {{ address?.settlementName }}</div>
                <div>District: {{ address?.districtName }}</div>
                <div>Region: {{ address?.regionName }}</div>
                <div>Country: {{ address?.countryName }}</div>
                <br>
                <div>Shipping Service</div>
                <div>{{ address?.shippingMethodName }}</div>
            </div>
            <div class="col">
                <div>Payment method</div>
                <div>{{ order.paymentMethod.method }}</div>
            </div>
        </div>
        <hr>

        <div class="mt-2">
            <div>Books</div>
            <div v-for="detailsItem in details">
                <div>Name: {{ detailsItem?.book?.name }}</div>
                <div>Category: {{ detailsItem?.book?.category?.name }}</div>
                <div>Publisher: {{ detailsItem?.book?.publisher?.name }}</div>
                <div>Format: {{ detailsItem?.bookFormat }}</div>
                <div>Quantity: {{ detailsItem?.quantity }}</div>
                <br>
            </div>
        </div>
    </div>
</template>