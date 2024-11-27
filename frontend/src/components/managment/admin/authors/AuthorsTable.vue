<script setup>
import SortableColumnHeader from '@/components/widgets/tables/SortableColumnHeader.vue';
import { ref } from 'vue';

const props = defineProps(['authors']);
const emit = defineEmits([
    'editBtnClicked',
    'deleteBtnClicked',
    'sortingChanged',
]);

const ID = 'id';
const FIRST = 'first_name';
const LAST = 'last_name';
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
                <th scope="col">Description</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="author in authors" :key="author.id">
                <td>{{ author.id }}</td>
                <td>{{ author.firstName }}</td>
                <td>{{ author.lastName }}</td>
                <td>{{ author.description }}</td>

                <td>
                    <button class="btn btn-warning" @click="emit('editBtnClicked',author)">
                        <img src="@/assets/icons/edit-icon.svg" alt="edit icon" width="10rem"/>
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger" @click="emit('deleteBtnClicked', author)">
                        <img src="@/assets/icons/delete-icon.svg" alt="delete icon" width="10rem"/>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>