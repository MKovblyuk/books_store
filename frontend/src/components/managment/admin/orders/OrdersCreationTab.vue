<script setup>
import SimpleLineChart from '@/components/widgets/charts/SimpleLineChart.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const labels = ref([]);
const data = ref([]);

onMounted(() => {
    fetchOrdersCreationInfo();
})

async function fetchOrdersCreationInfo() {
    const response = await axios.get('orders/creationInfo');

    if (response.status === 200) {
        labels.value = response.data.data.map(item => item.creationDate);
        data.value = response.data.data.map(item => item.ordersCount);
    }
}

</script>

<template>
    <div>
        <SimpleLineChart
            :labels
            :data
            title="Sales Chart"
            y-title="Sales count"
            data-set-label="Sales"
        />
    </div>
</template>