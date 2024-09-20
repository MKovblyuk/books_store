<script setup>

import OrderTable from "@/components/orders/OrderTable.vue";
import PaginationBar from "@/components/PaginationBar.vue";
import { useUserStore } from "@/stores/userStore";
import axios from "axios";
import { onMounted, ref } from "vue";

const orders = ref([]);
const userStore = useUserStore();
const isFetched = ref(false);
const meta = ref({});
const PER_PAGE = 10;

async function fetchOrders(page = 1) {
    try {
        const response = await axios.get('users/' + userStore.user.id + '/orders', {
            params: {
                page,
                per_page: PER_PAGE,
                include: 'details,address,shippingMethod',
            }
        });
        orders.value = response.data.data;
        meta.value = response.data.meta;
        isFetched.value = true;
    } catch (e) {
        console.log('Error in fetching orders:', e);
    }
}

onMounted(() => {
    fetchOrders();
});

</script>

<template>
    <section>
        Orders history tab
        <OrderTable
            :orders
        />

        <PaginationBar 
            v-if="meta.total > PER_PAGE"
            :meta
            @page_changed="page => fetchOrders(page)"
        />
    </section>
</template>