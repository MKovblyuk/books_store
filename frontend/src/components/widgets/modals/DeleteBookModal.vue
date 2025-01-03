<script setup>
import axios from 'axios';
import BaseModal from './BaseModal.vue';
import { ref } from 'vue';

const props = defineProps(['title', 'cancelBtnText', 'okBtnText','book']);
const emit = defineEmits(['bookDeleted']);
const bookDeleted = ref(false);

async function deleteBook() {
    const response = await axios.delete('books/' + props.book.id);

    if (response.status === 204) {
        bookDeleted.value = true;
        emit('bookDeleted');
    }
}

</script>

<template>
    <BaseModal
        :title="title"
        :cancel-btn-text="cancelBtnText"
        :ok-btn-text="okBtnText"
        :ok-btn-close-modal="false"
        @ok-btn-clicked="deleteBook"
        @modal-hidden="bookDeleted=false"
    >
        <div v-if="bookDeleted">
            Book successfully deleted
        </div>
        <div v-else>
            <div>Do you want to delete book:</div>
            <div>id: {{ book?.id }}</div>
            <div>{{ book?.name}}</div>
        </div>
    </BaseModal>
</template>