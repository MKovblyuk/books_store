<script setup>
import axios from 'axios';
import BaseModal from './BaseModal.vue';
import { ref } from 'vue';

const props = defineProps(['title', 'cancelBtnText', 'okBtnText','publisher']);
const emit = defineEmits(['publisherDeleted']);
const publisherDeleted = ref(false);

async function deletePublisher() {
    const response = await axios.delete('publishers/' + props.publisher.id);

    if (response.status === 204) {
        publisherDeleted.value = true;
        emit('publisherDeleted');
    }
}

</script>

<template>
    <BaseModal
        :title="title"
        :cancel-btn-text="cancelBtnText"
        :ok-btn-text="okBtnText"
        :ok-btn-close-modal=false
        @ok-btn-clicked="deletePublisher"
        @modal-hidden="publisherDeleted=false"
    >
        <div v-if="publisherDeleted">
            Publisher successfully deleted
        </div>
        <div v-else>
            <div>Do you want to delete publisher:</div>
            <div>id: {{ publisher?.id }}</div>
            <div>{{ publisher?.name }}</div>
        </div>
    </BaseModal>
</template>