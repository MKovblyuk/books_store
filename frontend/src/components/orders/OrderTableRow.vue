<script setup>

const props = defineProps(['order']);
const emptySign = '____';

</script>

<template>

<tr>
    <td>{{ order.status }}</td>
    <td>{{ order.streetAddress ?? emptySign}}</td>
    <td>{{ order.settlement ?? emptySign}}</td>
    <td>{{ order.district ?? emptySign}}</td>
    <td>{{ order.region ?? emptySign }}</td>
    <td>{{ order.shippingMethod ?? emptySign }}</td>
    <td>{{ order.totalPrice }}</td>
    <td>{{ (new Date(order.createdAt)).toUTCString()  }}</td>
    <td>
        <div class="d-flex justify-content-center">
            <button class="btn btn-primary" @click="$emit('showDetails', order.id)">...</button>
        </div>
    </td>
</tr>

</template>