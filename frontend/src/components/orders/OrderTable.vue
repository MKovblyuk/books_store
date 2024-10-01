<script setup>
import { ref } from 'vue';
import OrderTableRow from './OrderTableRow.vue';
import * as bootstrap from 'bootstrap';
import axios from 'axios';
import { useIdGenerator } from '@/composables/idGenerator';


const props = defineProps(['orders']);
const detailsModal = ref(null);
const orderDetails = ref([]);


async function showDetails(orderId) {
    const response = await axios.get('orders/'+ orderId +'/details');
    orderDetails.value = response.data.data;

    useIdGenerator().addIds(orderDetails.value);

    const bookNamePromises = orderDetails.value.map(async (detail) => {
      const bookResponse = await axios.get('books/' + detail.bookId + '?fields[books]=name');
      return { ...detail, bookName: bookResponse.data.data.name };
    });

    orderDetails.value = await Promise.all(bookNamePromises);
    bootstrap.Modal.getOrCreateInstance(detailsModal.value).show();
}

</script>

<template>
    <div>
        <table v-if="orders.length > 0" class="table">
            <thead>
                <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Street Address</th>
                    <th scope="col">Settlement</th>
                    <th scope="col">District</th>
                    <th scope="col">Region</th>
                    <th scope="col">Shipping Method</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Created</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody>
                <OrderTableRow 
                    v-for="order in orders" 
                    :key="order.id" 
                    :order 
                    @showDetails="showDetails"
                />
            </tbody>
        </table>
        <div v-else class="d-flex justify-content-center">
            Orders Table Empty
        </div>


        <div class="modal" ref="detailsModal" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-for="detail in orderDetails" :key="detail.id">
                            <div>Name: {{ detail.bookName }}</div>
                            <div>Book Format: {{ detail.bookFormat }}</div>
                            <div>Quantity: {{ detail.quantity }}</div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</template>