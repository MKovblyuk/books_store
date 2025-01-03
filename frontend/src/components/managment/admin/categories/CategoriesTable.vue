<script setup>

const props = defineProps(['categories']);
const emit = defineEmits([
    'editBtnClicked',
    'deleteBtnClicked',
]);

</script>

<template>
    <table class="table fs-6">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="category in categories" :key="category.id">
                <td>{{ category.id }}</td>
                <td>{{ category.name }}</td>

                <td>
                    <button class="btn btn-warning" @click="emit('editBtnClicked',category)">
                        <img src="@/assets/icons/edit-icon.svg" alt="edit icon" width="10rem"/>
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger" @click="emit('deleteBtnClicked', category)">
                        <img src="@/assets/icons/delete-icon.svg" alt="delete icon" width="10rem"/>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>