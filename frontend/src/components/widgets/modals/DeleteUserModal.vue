<script setup>
import axios from 'axios';
import BaseModal from './BaseModal.vue';
import { ref } from 'vue';

const props = defineProps(['title', 'cancelBtnText', 'okBtnText','user']);
const emit = defineEmits(['userDeleted']);
const userDeleted = ref(false);

async function deleteUser() {
    const response = await axios.delete('users/' + props.user.id);

    if (response.status === 204) {
        userDeleted.value = true;
        emit('userDeleted');
    }
}

</script>

<template>
    <BaseModal
        :title="title"
        :cancel-btn-text="cancelBtnText"
        :ok-btn-text="okBtnText"
        :ok-btn-close-modal="false"
        @ok-btn-clicked="deleteUser"
        @modal-hidden="userDeleted=false"
    >
        <div v-if="userDeleted">
            User successfully deleted
        </div>
        <div v-else>
            <div>Do you want to delete user:</div>
            <div>id: {{ user?.id }}</div>
            <div>{{ user?.firstName + " " + user?.lastName}}</div>
        </div>
    </BaseModal>
</template>