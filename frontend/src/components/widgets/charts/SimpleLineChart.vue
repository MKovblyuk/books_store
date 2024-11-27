<script setup>
import LineChart from './LineChart.vue';

const props = defineProps(['labels', 'data', 'dataSetLabel', 'title', 'xTitle', 'yTitle']);

</script>

<template>
     <LineChart
        :labels
        :title
        :x-title="xTitle"
        :y-title="yTitle"
        :datasets="[{
            label: props.dataSetLabel,
            data: props.data,
            backgroundColor: 'rgba(54,73,93,.5)',
            borderColor: '#36495d',
            borderWidth: 3
        }]"
     />
</template>