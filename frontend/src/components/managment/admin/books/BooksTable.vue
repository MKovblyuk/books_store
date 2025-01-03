<script setup>
import SortableColumnHeader from '@/components/widgets/tables/SortableColumnHeader.vue';
import { ref } from 'vue';

const props = defineProps(['books']);
const emit = defineEmits([
    'editBtnClicked',
    'deleteBtnClicked',
    'sortingChanged',
]);

const ID = 'id';
const NAME = 'name';
const PUBLICATION_YEAR = 'publication_year';
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
                        @click="activeColumn = NAME" 
                        :is-active="activeColumn === NAME"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, NAME)"
                    >
                        Name
                    </SortableColumnHeader>
                </th>

                <th scope="col">Description</th>
                <th scope="col">Language</th>
                <th scope="col">Publisher</th>
                <th scope="col">Category</th>

                <th scope="col">
                    <SortableColumnHeader 
                        @click="activeColumn = PUBLICATION_YEAR" 
                        :is-active="activeColumn === PUBLICATION_YEAR"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, PUBLICATION_YEAR)"
                    >
                        Publication year
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
            </tr>
        </thead>
        <tbody>
            <tr v-for="book in books" :key="book.id">
                <td>{{ book.id }}</td>
                <td>{{ book.name }}</td>
                <td>{{ book.description }}</td>
                <td>{{ book.language }}</td>
                <td>{{ book.publisher?.name }}</td>
                <td>{{ book.category?.name }}</td>
                <td>{{ book.publicationYear }}</td>
                <td>{{ new Date(book.createdAt).toLocaleDateString() }}</td>
                <td>{{ new Date(book.updatedAt).toLocaleDateString() }}</td>
                <td>
                    <button class="btn btn-warning" @click="emit('editBtnClicked',book)">
                        <img src="@/assets/icons/edit-icon.svg" alt="edit icon" width="10rem"/>
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger" @click="emit('deleteBtnClicked', book)">
                        <img src="@/assets/icons/delete-icon.svg" alt="delete icon" width="10rem"/>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>