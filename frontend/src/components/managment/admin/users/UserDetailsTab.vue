<script setup>
import OrderTable from '@/components/orders/OrderTable.vue';
import PaginationBar from '@/components/widgets/PaginationBar.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';


const props = defineProps(['user']);
const emit = defineEmits(['tryReturn']);

const details = ref({
    ordersCount: '',
    receivedOrdersCount: '',
    notReceivedOrdersCount: '',
    totalAmountOfPurchases: '',
});

const ordersList = ref([]);
const ordersListMeta = ref();
const ORDERS_PER_PAGE = 5;


async function fetchDetails() {
    const response = await axios.get('users/' + props.user.id + '/details');

    if (response.status === 200) {
        details.value = response.data.data;
    }
}

async function fetchOrdersList(page = 1) {
    const response = await axios.get('users/' + props.user.id + '/orders', {
        params: {
            page: page,
            per_page: ORDERS_PER_PAGE
        }
    })

    if (response.status === 200) {
        ordersList.value = response.data.data;
        ordersListMeta.value = response.data.meta;
    }
}

onMounted(() => {
    fetchDetails();
    fetchOrdersList();
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
                <div>ID: {{ user.id }}</div>
                <div>{{ user.firstName + " " + user.lastName}}</div>
                <div>{{ user.email }}</div>
                <div>{{ user.phoneNumber }}</div>
            </div>
            <div class="col"> 
                <div>All orders count: {{ details.ordersCount }}</div>
                <div>Received orders count: {{ details.receivedOrdersCount }}</div>
                <div>Not received orders count: {{ details.notReceivedOrdersCount }}</div>
                <div>Total amount of purchases: {{ details.totalAmountOfPurchases }}</div>
            </div>
        </div>
        <hr>

        <div class="mt-2">
            <div class="mb-2">Order history</div>
            <OrderTable :orders="ordersList"/>
            <PaginationBar 
                v-if="ordersListMeta?.total > ORDERS_PER_PAGE"
                :meta="ordersListMeta"
                @page_changed="page => fetchOrdersList(page)"
            />
        </div>
    </div>
</template>