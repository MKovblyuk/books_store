<script setup>

import { CategoryScale, Chart, Legend, LinearScale, LineController, LineElement, PointElement, Title } from 'chart.js';
import { onUpdated, ref } from 'vue';

const props = defineProps(['labels', 'datasets', 'title', 'xTitle', 'yTitle'])
const context = ref();
var myChart;

Chart.register(
    LineController, LinearScale, CategoryScale, PointElement, 
    LineElement, Title, Legend
);

onUpdated(() => {
    updateChart();
});

function updateChart() {
    myChart?.destroy();

    myChart = new Chart(context.value, {
        type: 'line',
        data: {
            labels: props.labels,
            datasets: props.datasets,
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: props.title
                }
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: props.xTitle
                    }
                },
                y: {
                    display: true,
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: props.yTitle
                    }
                }
            }
        }
    });
}

</script>

<template>
    <canvas ref="context"></canvas>
</template>