<script setup>
import SortableColumnHeader from '@/components/widgets/tables/SortableColumnHeader.vue';
import { ref } from 'vue';

const props = defineProps(['publishers']);
const emit = defineEmits([
    'editBtnClicked',
    'deleteBtnClicked',
    'sortingChanged',
]);

const ID = 'id';
const NAME = 'name';
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
                        @click="activeColumn = NAME" 
                        :is-active="activeColumn === NAME"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, NAME)"
                    >
                        Name
                    </SortableColumnHeader>
                </th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="publisher in publishers" :key="publisher.id">
                <td>{{ publisher.id }}</td>
                <td>{{ publisher.name }}</td>
                
                <td>
                    <button class="btn btn-warning" @click="emit('editBtnClicked',publisher)">
                        <img src="@/assets/icons/edit-icon.svg" alt="edit icon" width="10rem"/>
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger" @click="emit('deleteBtnClicked', publisher)">
                        <img src="@/assets/icons/delete-icon.svg" alt="delete icon" width="10rem"/>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>