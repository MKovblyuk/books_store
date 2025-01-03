<script setup>
import axios from 'axios';
import { onMounted, ref, watch, watchEffect } from 'vue';
import SelectDeliveryPlaceModal from '@/components/widgets/modals/SelectDeliveryPlaceModal.vue';

const props = defineProps(['order']);
const emit = defineEmits(['orderUpdated', 'tryReturn']);

const errors = ref();
const orderUpdated = ref(false);
const newOrderData = ref({...props.order});
const address = ref();
const showDeliveryPlaceSelects = ref(false);


onMounted(() => {
    fetchAddress();
})

watch(
    () => newOrderData, 
    () => fetchAddress(),
    {deep: true}
);

async function updateOrder() {
    try {
        const response = await axios.patch('orders/' + props.order.id, newOrderData.value);

        if (response.status === 200) {
            orderUpdated.value = true;
            alert('Order updated');
            emit('orderUpdated');
        }
    } catch(e) {
        if (e.response.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
}

async function fetchAddress() {
    const response = await axios.get('deliveryPlaces/' + newOrderData.value.deliveryPlaceId + '/fullAddress');
    
    if (response.status === 200) {
        address.value = response.data.data;
    }
}

</script>

<template>
    <div>
        <div>
            <button class="btn btn-success" @click="emit('tryReturn')">
                &lArr;
            </button>
        </div>
        <div>
            <div class="mb-3">
                <label for="statusSelect" class="form-label">
                    Status
                </label>
                <select v-model="newOrderData.status" class="form-select" id="statusSelect">
                    <option value="Pending">Pending</option>
                    <option value="Received">Received</option>
                    <option value="Sent">Sent</option>
                    <option value="Refused">Refused</option>
                    <option value="Preparing">Preparing</option>
                    <option value="ReadyToSend">ReadyToSend</option>
                </select>
                <div class="text-danger">{{ errors?.status?.[0] }}</div>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Address
                </label>
                <div>Country: {{ address?.countryName }}</div>
                <div>Region: {{ address?.regionName }}</div>
                <div>District: {{ address?.districtName }}</div>
                <div>Settlement: {{ address?.settlementName }}</div>
                <div>Delivery place: {{ address?.streetAddress }}</div>
                
                <button 
                    class="btn btn-primary mt-2" 
                    @click="showDeliveryPlaceSelects = true"
                    data-bs-toggle="modal" 
                    data-bs-target="#selectDeliveryPlaceModal"
                >
                    Change
                </button>

                <SelectDeliveryPlaceModal
                    ok-btn-text="Select"
                    title="Select Delivery Place"
                    id="selectDeliveryPlaceModal"
                    @delivery-place-id-selected="id => newOrderData.deliveryPlaceId = id"
                />
            </div>
        </div>
        <div class="p-1">
            <button class="btn btn-primary me-1" @click="newOrderData = {...order}">Reset</button>
            <button class="btn btn-primary" @click="updateOrder">Update</button>
        </div>
    </div>
</template>