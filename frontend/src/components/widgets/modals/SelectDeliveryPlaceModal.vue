<script setup>
import BaseModal from './BaseModal.vue';
import { ref } from 'vue';
import DeliveryPlaceSelects from '@/components/orders/DeliveryPlaceSelects.vue';

const props = defineProps(['title', 'cancelBtnText', 'okBtnText']);
const emit = defineEmits(['deliveryPlaceIdSelected']);

const deliveryPlaceId = ref();

function handleOkBtnClick() {
    if (deliveryPlaceId.value) {
        emit('deliveryPlaceIdSelected', deliveryPlaceId.value);
    }
}

</script>

<template>
    <BaseModal
        :title="title"
        :cancel-btn-text="cancelBtnText"
        :ok-btn-text="okBtnText"
        :ok-btn-close-modal=true
        @ok-btn-clicked="handleOkBtnClick"
    >
       <DeliveryPlaceSelects
            @delivery_place_id_changed="id => deliveryPlaceId = id"
       />
    </BaseModal>
</template>