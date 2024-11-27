<script setup>
import PaginationBar from '@/components/widgets/PaginationBar.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import OrdersTable from './OrdersTable.vue';
import FilterOrdersForm from './FilterOrdersForm.vue';
import OrderDetailsTab from './OrderDetailsTab.vue';
import EditOrderTab from './EditOrderTab.vue';

const showFilterForm = ref(false);

const orders = ref([]);
const meta = ref();
const selectedOrder = ref();

const PER_PAGE = 8;
const filterParams = ref({});
const sortParam = ref();

const MAIN_TAB = 'main_tab';
const EDIT_ORDER_TAB = 'edit_order_tab';
const ORDER_DETAILS_TAB = 'order_details_tab';
const activeTab = ref(MAIN_TAB);

onMounted(() => {
    fetchOrders();
})

async function fetchOrders(page = 1) {
    const response = await axios.get('/orders', {
        params: {
            page: page,
            per_page: PER_PAGE,
            sort: sortParam.value,
            ...filterParams.value,
            'include': 'user,paymentMethod',
        }
    });

    orders.value = response.data.data;
    meta.value = response.data.meta;
}

async function fetchUsersIds(email = '', phoneNumber = '') {
    const response = await axios.get('/users', {
        params: {
            'fields[users]': 'id',
            'filter[email]': email,
            'filter[phone_number]': phoneNumber
        }
    });

    return response.data.data.map(item => item.id).join(',');;
}

function setFilterParams(data) {
    filterParams.value['filter[id]'] = data?.id;
    filterParams.value['filter[user_id]']  = data?.usersIds;
    filterParams.value['filter[created_at]']  = data?.createdAt;
    filterParams.value['filter[updated_at]']  = data?.updatedAt;
}

async function filterChangedHandler(data) {

    if (data.user.email || data.user.phoneNumber) {
        data.usersIds = await fetchUsersIds(data.user.email, data.user.phoneNumber)

        if (!data.usersIds) {
            orders.value = [];
            return;
        }
    }

    setFilterParams(data);
    fetchOrders();
}

function sortingChangedHandler(isAsc, column) {
    sortParam.value = (isAsc ? '-' : '') + column;
    fetchOrders();
}

function showEditOrderTab(order) {
    selectedOrder.value = order;
    activeTab.value = EDIT_ORDER_TAB;
}

function showOrderDetailsTab(order) {
    selectedOrder.value = order;
    activeTab.value = ORDER_DETAILS_TAB;
}

</script>

<template>
    <div>
        <div v-show="activeTab === MAIN_TAB">
            <div class="mb-2">
                <button class="btn btn-primary mb-1" @click="showFilterForm = !showFilterForm">
                    {{ showFilterForm ? 'Hide' : 'Search' }}
                </button>

                <FilterOrdersForm
                    v-show="showFilterForm"
                    @filter-changed="filterChangedHandler"
                />
            </div>

            <OrdersTable 
                :orders
                @sorting-changed="sortingChangedHandler"
                @edit-btn-clicked="showEditOrderTab"
                @details-btn-clicked="showOrderDetailsTab"
            />

            <PaginationBar 
                v-if="meta"
                :meta
                @page_changed="newPage => fetchOrders(newPage)"
            />
        </div>

        <EditOrderTab
            v-if="activeTab === EDIT_ORDER_TAB"    
            class="mt-2"
            :order="selectedOrder"
            @try-return="activeTab = MAIN_TAB"
            @order-updated="fetchOrders"
        />

        <OrderDetailsTab 
            v-if="activeTab === ORDER_DETAILS_TAB"
            class="mt-2"
            :order="selectedOrder"
            @try-return="activeTab = MAIN_TAB"
        />
    </div>
</template>

<style scoped>
@media screen and (max-width:1400px) {
    table {
        font-size: 0.6rem !important;
    }
}
</style>