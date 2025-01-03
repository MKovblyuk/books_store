<script setup>
import axios from 'axios';
import BaseModal from './BaseModal.vue';
import { ref } from 'vue';

const props = defineProps(['title', 'cancelBtnText', 'okBtnText','author']);
const emit = defineEmits(['authorDeleted']);
const authorDeleted = ref(false);

async function deleteAuthor() {
    const response = await axios.delete('authors/' + props.author.id);

    if (response.status === 204) {
        authorDeleted.value = true;
        emit('authorDeleted');
    }
}

</script>

<template>
    <BaseModal
        :title="title"
        :cancel-btn-text="cancelBtnText"
        :ok-btn-text="okBtnText"
        :ok-btn-close-modal=false
        @ok-btn-clicked="deleteAuthor"
        @modal-hidden="authorDeleted=false"
    >
        <div v-if="authorDeleted">
            Author successfully deleted
        </div>
        <div v-else>
            <div>Do you want to delete author:</div>
            <div>id: {{ author?.id }}</div>
            <div>{{ author?.firstName + " " + author?.lastName}}</div>
        </div>
    </BaseModal>
</template>