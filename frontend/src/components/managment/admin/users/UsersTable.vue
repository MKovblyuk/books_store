<script setup>
import SortableColumnHeader from '@/components/widgets/tables/SortableColumnHeader.vue';
import { ref } from 'vue';

const props = defineProps(['users']);
const emit = defineEmits([
    'editBtnClicked',
    'detailsBtnClicked',
    'deleteBtnClicked',
    'sortingChanged',
]);

const ID = 'id';
const FIRST = 'first_name';
const LAST = 'last_name';
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
                    <SortableColumnHeader 
                        @click="activeColumn = FIRST" 
                        :is-active="activeColumn === FIRST"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, FIRST)"
                    >
                        First
                    </SortableColumnHeader>
                </th>
    
                <th scope="col">
                    <SortableColumnHeader 
                        @click="activeColumn = LAST" 
                        :is-active="activeColumn === LAST"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, LAST)"
                    >
                        Last
                    </SortableColumnHeader>
                </th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Role</th>
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
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.firstName }}</td>
                <td>{{ user.lastName }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.phoneNumber }}</td>
                <td>{{ user.role }}</td>
                <td>{{ new Date(user.createdAt).toLocaleDateString() }}</td>
                <td>{{ new Date(user.updatedAt).toLocaleDateString() }}</td>
                <td>
                    <button class="btn btn-success" @click="emit('detailsBtnClicked',user)">
                        Details
                    </button>
                </td>
                <td>
                    <button class="btn btn-warning" @click="emit('editBtnClicked',user)">
                        <img src="@/assets/icons/edit-icon.svg" alt="edit icon" width="10rem"/>
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger" @click="emit('deleteBtnClicked', user)">
                        <img src="@/assets/icons/delete-icon.svg" alt="delete icon" width="10rem"/>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>