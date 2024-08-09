<script setup>

const props = defineProps(['order']);

</script>

<template>

<tr>
    <td>{{ order.status }}</td>
    <td>{{ order.address.settlementName }}</td>
    <td>{{ order.address.streetName }}</td>
    <td>{{ order.address.streetNumber }}</td>
    <td>{{ order.address.districtName }}</td>
    <td>{{ order.address.regionName }}</td>
    <td>{{ order.shippingMethod.name }}</td>
    <td>{{ (new Date(order.createdAt)).toUTCString()  }}</td>
    <td class="d-flex justify-content-center">
        <button class="btn btn-primary btn-sm" @click="$emit('showDetails', order)">...</button>
    </td>
</tr>

</template>