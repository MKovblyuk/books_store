<script setup>
import SortableColumnHeader from '@/components/widgets/tables/SortableColumnHeader.vue';
import { useConfigStore } from '@/stores/configStore';
import { ref } from 'vue';

const props = defineProps(['reviews']);
const emit = defineEmits([
    'deleteBtnClicked',
    'sortingChanged',
]);

const RATING = 'rating';
const UPDATED_AT = 'updated_at';
const activeColumn = ref();

</script>

<template>
    <table class="table fs-6">
        <thead>
            <tr>
                <th scope="col">
                    <SortableColumnHeader 
                        @click="activeColumn = RATING" 
                        :is-active="activeColumn === RATING"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, RATING)"
                    >
                        Raiting
                    </SortableColumnHeader>
                </th>
                <th scope="col">Review</th>
                <th scope="col">User</th>
                <th scope="col">
                    <SortableColumnHeader 
                        @click="activeColumn = UPDATED_AT" 
                        :is-active="activeColumn === UPDATED_AT"
                        @sorting_order_chaged="isAsc => emit('sortingChanged', isAsc, UPDATED_AT)"
                    >
                        Updated
                    </SortableColumnHeader>
                </th>
                <th scope="col">Book</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="review in reviews" :key="review.id">
                <td>{{ review.rating }}</td>
                <td>{{ review.review }}</td>
                <td>{{ review.userLastName + ' ' + review.userFirstName }}</td>
                <td>{{ (new Date(review.updatedAt)).toLocaleString(useConfigStore().locale, {hour12: false}) }}</td>
                <td>{{ review.book.name }}</td>

                <td>
                    <button class="btn btn-danger" @click="emit('deleteBtnClicked', review)">
                        <img src="@/assets/icons/delete-icon.svg" alt="delete icon" width="10rem"/>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>