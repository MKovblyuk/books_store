<script setup>
import axios from 'axios';
import BaseModal from './BaseModal.vue';
import { ref } from 'vue';

const props = defineProps(['title', 'cancelBtnText', 'okBtnText','category']);
const emit = defineEmits(['categoryDeleted']);
const categoryDeleted = ref(false);

async function deleteCategory() {
    const response = await axios.delete('categories/' + props.category.id);

    if (response.status === 204) {
        categoryDeleted.value = true;
        emit('categoryDeleted');
    }
}

</script>

<template>
    <BaseModal
        :title="title"
        :cancel-btn-text="cancelBtnText"
        :ok-btn-text="okBtnText"
        :ok-btn-close-modal=false
        @ok-btn-clicked="deleteCategory"
        @modal-hidden="categoryDeleted=false"
    >
        <div v-if="categoryDeleted">
            Category successfully deleted
        </div>
        <div v-else>
            <div>Do you want to delete category:</div>
            <div>id: {{ category?.id }}</div>
            <div>{{ category?.name }}</div>
        </div>
    </BaseModal>
</template>