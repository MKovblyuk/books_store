<script setup>
import SimpleLineChart from '@/components/widgets/charts/SimpleLineChart.vue';
import SwitchButtonsGroup from '@/components/widgets/SwitchButtonsGroup.vue';
import { useMonthsLabels } from '@/composables/monthsLabels';
import { useStatisticFormatter } from '@/composables/statisticFormatter';
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';

const data = ref([]);
const selectedYear = ref((new Date()).getFullYear());
const { labels } = useMonthsLabels(selectedYear);

onMounted(() => {
    fetchOrdersCreationInfo();
})

watch(selectedYear,() => fetchOrdersCreationInfo());

async function fetchOrdersCreationInfo() {
    const response = await axios.get('orders/creationInfo', {
        params: {
            year: selectedYear.value
        }
    });

    if (response.status === 200) {
        data.value = useStatisticFormatter(selectedYear.value)
            .getData(response.data.data[0], (item) => item[0]?.ordersCount);
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
        <SwitchButtonsGroup 
            class="mt-2 d-flex justify-content-center"
            v-model="selectedYear"
        />
    </div>
</template>