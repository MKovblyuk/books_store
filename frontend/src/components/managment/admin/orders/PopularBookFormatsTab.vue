<script setup>
import LineChart from '@/components/widgets/charts/LineChart.vue';
import SwitchButtonsGroup from '@/components/widgets/SwitchButtonsGroup.vue';
import { useMonthsLabels } from '@/composables/monthsLabels';
import { useStatisticFormatter } from '@/composables/statisticFormatter';
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';

const datasets = ref([]);
const statData = ref([]);
const selectedYear = ref((new Date()).getFullYear());
const { labels } = useMonthsLabels(selectedYear);

onMounted(() => {
    fetchBookFormatsStat();
})

watch(selectedYear,() => fetchBookFormatsStat());

function getDataForFormat(format) {
    return useStatisticFormatter(selectedYear.value).getData(
        statData.value,
        data => data.filter(d => d.format === format)[0]?.soldCount ?? 0
    );
}

function setDataSets() {
    datasets.value = [
        {
            label: 'Paper',
            data: getDataForFormat('Paper'),
            backgroundColor: "rgba(240,10,10,.5)",
            borderColor: "rgba(240,10,10,.5)",
            borderWidth: 3
        },
        {
            label: 'Electronic',
            data: getDataForFormat('Electronic'),
            backgroundColor: "rgba(10,240,10,.5)",
            borderColor: "rgba(10,240,10,.5)",
            borderWidth: 3
        },
        {
            label: 'Audio',
            data: getDataForFormat('Audio'),
            backgroundColor: "rgba(10,10,240,.5)",
            borderColor: "rgba(10,10,240,.5)",
            borderWidth: 3
        },
    ]
}

async function fetchBookFormatsStat() {
    const response = await axios.get('orders/bookFormatsStat', {
        params: {
            year: selectedYear.value
        }
    });

    if (response.status === 200) {
        statData.value = response.data.data[0];
        setDataSets();
    }
}

</script>

<template>
    <div>
        <LineChart
            :labels
            :datasets
            title="Popular book formats"
            y-title="Sales count"
        />
        <SwitchButtonsGroup 
            class="mt-2 d-flex justify-content-center"
            v-model="selectedYear"
        />
    </div>
</template>