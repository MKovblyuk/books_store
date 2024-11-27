<script setup>
import SortableColumnHeader from '@/components/widgets/tables/SortableColumnHeader.vue';
import { useConfigStore } from '@/stores/configStore';
import { ref } from 'vue';

const props = defineProps(['orders']);
const emit = defineEmits([
    'editBtnClicked',
    'detailsBtnClicked',
    'sortingChanged',
]);

const ID = 'id';
const TOTAL_PRICE = 'total_price';
const CREATED = 'created_at';
const UPDATED = 'updated_at';
const activeColumn = ref();

</script>

<template>
    <table class="table fs-6">
        <thead>
            <tr>
                <th scope="col">
                    <SortableColumnHeader 
                        @click="activeColumn = ID" 
                        :is-active="activeColumn === ID"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, ID)"
                    >
                        id
                    </SortableColumnHeader>
                </th>
                <th scope="col">
                    Status
                </th>
                <th scope="col">
                    First Name
                </th>
                <th scope="col">
                    Last Name
                </th>
                <th scope="col">
                    Email
                </th>
                <th scope="col">
                    Phone Number
                </th>
                <th scope="col">
                    <SortableColumnHeader 
                        @click="activeColumn = TOTAL_PRICE" 
                        :is-active="activeColumn === TOTAL_PRICE"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, TOTAL_PRICE)"
                    >
                        Total price
                    </SortableColumnHeader>
                </th>
                <th scope="col">
                    <SortableColumnHeader 
                        @click="activeColumn = CREATED" 
                        :is-active="activeColumn === CREATED"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, CREATED)"
                    >
                        Created
                    </SortableColumnHeader>
                </th>
                <th scope="col">
                    <SortableColumnHeader 
                        @click="activeColumn = UPDATED" 
                        :is-active="activeColumn === UPDATED"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, UPDATED)"
                    >
                        Updated
                    </SortableColumnHeader>
                </th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="order in orders" :key="order.id">
                <td>{{ order.id }}</td>
                <td>{{ order.status }}</td>
                <td>{{ order.user.firstName }}</td>
                <td>{{ order.user.lastName }}</td>
                <td>
                    <a v-if="order.user.email" :href="'mailto:' + order.user.email ">
                        {{ order.user.email  }}
                    </a>
                </td>
                <td>{{ order.user.phoneNumber }}</td>
                <td>{{ order.totalPrice }}</td>
                <td>
                    {{ new Date(order.createdAt).toLocaleString(useConfigStore().locale,{hour12: false}) }}
                </td>
                <td>
                    {{ new Date(order.updatedAt).toLocaleString(useConfigStore().locale,{hour12: false}) }}
                </td>
                <td>
                    <button class="btn btn-success" @click="emit('detailsBtnClicked',order)">
                        Details
                    </button>
                </td>
                <td>
                    <button class="btn btn-warning" @click="emit('editBtnClicked',order)">
                        <img src="@/assets/icons/edit-icon.svg" alt="edit icon" width="10rem"/>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>