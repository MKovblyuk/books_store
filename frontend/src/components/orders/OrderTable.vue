<script setup>
import { ref } from 'vue';
import OrderTableRow from './OrderTableRow.vue';
import * as bootstrap from 'bootstrap';
import axios from 'axios';


const props = defineProps(['orders']);
const detailedOrder = ref({
    'details': []
});


function showDetails(order) {
    detailedOrder.value = order;
    generateIds(detailedOrder.value.details);
    fetchBookNames();

    const detailsModal = document.getElementById('detailsModal');
    const modal = bootstrap.Modal.getOrCreateInstance(detailsModal);
    modal.show();
}

function generateIds(arr) {
    for (let i = 0; i < arr.length; i++) {
        arr[i].id = Date.now().toString() + i;
    }
}

function fetchBookNames() {
    detailedOrder.value.details.forEach(async detail => {
        const response = await axios.get('books/' + detail.book_id + '?fields[books]=name');
        detail.book_name = response.data.data.name;
    });
}

function getTotalPriceSum(details) {
    return details?.reduce((accumulator, currentValue) => accumulator + parseFloat(currentValue.total_price), 0);
}

</script>

<template>
    <div>
        <table v-if="orders.length > 0" class="table">
            <thead>
                <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Settlement</th>
                    <th scope="col">Street</th>
                    <th scope="col">Street Number</th>
                    <th scope="col">District</th>
                    <th scope="col">Region</th>
                    <th scope="col">Shipping Method</th>
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


        <div class="modal" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-for="detail in detailedOrder.details" :key="detail.id">
                            <div>Name: {{ detail.book_name }}</div>
                            <div>Book Format: {{ detail.book_format }}</div>
                            <div>Quantity: {{ detail.quantity }}</div>
                            <div>Total Price: {{ detail.total_price }}</div>
                            <br>
                        </div>
                        <div>
                            Total: {{ getTotalPriceSum(detailedOrder.details) }}
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</template>