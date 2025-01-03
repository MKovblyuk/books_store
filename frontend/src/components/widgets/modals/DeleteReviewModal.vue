<script setup>
import axios from 'axios';
import BaseModal from './BaseModal.vue';
import { ref } from 'vue';

const props = defineProps(['title', 'cancelBtnText', 'okBtnText','review']);
const emit = defineEmits(['reviewDeleted']);
const reviewDeleted = ref(false);

async function deletereview() {
    const response = await axios.delete('reviews/' + props.review.id);

    if (response.status === 204) {
        reviewDeleted.value = true;
        emit('reviewDeleted');
    }
}

</script>

<template>
    <BaseModal
        :title="title"
        :cancel-btn-text="cancelBtnText"
        :ok-btn-text="okBtnText"
        :ok-btn-close-modal=false
        @ok-btn-clicked="deletereview"
        @modal-hidden="reviewDeleted=false"
    >
        <div v-if="reviewDeleted">
            Review successfully deleted
        </div>
        <div v-else>
            <div>Do you want to delete review:</div>
            <div>id: {{ review?.id }}</div>
            <div>{{ review?.userLastName + " " + review?.userFirstName}}</div>
            <div>{{ review?.review }}</div>
        </div>
    </BaseModal>
</template>