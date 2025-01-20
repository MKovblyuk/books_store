<script setup>
import LineChart from '@/components/widgets/charts/LineChart.vue';
import SwitchButtonsGroup from '@/components/widgets/SwitchButtonsGroup.vue';
import { useStatisticFormatter } from '@/composables/statisticFormatter';
import { ColorGenerator } from '@/helpers/ColorGenerator';
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';

const labels = ref([]);
const datasets = ref([]);
const statData = ref([]);
const selectedYear = ref((new Date()).getFullYear());
const categories = ref([]);
const parentCategoryIdsHistory = [];

onMounted(() => {
    fetchCategories().then(() => fetchCategoriesStat());
})

watch(selectedYear,() => fetchCategoriesStat());


function setLabels() {
    labels.value = useStatisticFormatter(selectedYear.value)
        .getMonthsNumbers(selectedYear.value)
        .map(item => item + '/' + selectedYear.value);
}

function getDataForCategory(categoryId) {
    return useStatisticFormatter(selectedYear.value).getData(
        statData.value,
        data => data.filter(d => d.categoryId == categoryId)[0]?.soldCount ?? 0
    );
}

function setDataSets() {
    const colorGenerator = new ColorGenerator();
    const tmpDatasets = [];

    categories.value.forEach(category => {
        const color = colorGenerator.getAvailableRgbString();

        tmpDatasets.push({
            label: category.name,
            data: getDataForCategory(category.id),
            backgroundColor: color,
            borderColor: color,
            borderWidth: 3
        });
    });

    datasets.value = tmpDatasets;
}

async function fetchCategoriesStat() {
    const response = await axios.get('orders/categoriesStat', {
        params: {
            'year': selectedYear.value
        }
    });

    if (response.status === 200) {
        statData.value = response.data.data[0];

        setLabels();
        setDataSets();
    }
}

async function fetchCategories() {
    const response = await axios.get('categories');
    
    if (response.status === 200) {
        categories.value = response.data.data;
    }
}

async function fetchChildCategories(parentId) {
    const response = await axios.get('categories/'+ parentId +'/children');

    if (response.status === 200) {
        categories.value = response.data.data;
    }
}

async function fetchSiblingsAndSelfCategories(categoryId) {
    const response = await axios.get('categories/'+ categoryId +'/siblingsAndSelf');

    if (response.status === 200) {
        categories.value = response.data.data;
    }
}

function updateDataSets(parentCategoryId) {
    parentCategoryIdsHistory.push(parentCategoryId);
    fetchChildCategories(parentCategoryId).then(() => setDataSets());
}

function back() {
    const parentCategoryId = parentCategoryIdsHistory.pop();

    if (parentCategoryId) {
        fetchSiblingsAndSelfCategories(parentCategoryId).then(() => setDataSets());
    } else {
        fetchCategories().then(() => setDataSets());
    }
}

</script>

<template>
    <div>
        <LineChart
            :labels
            :datasets
            title="Popular categories"
            y-title="Sales count"
        />
        <SwitchButtonsGroup 
            class="mt-2 d-flex justify-content-center"
            v-model="selectedYear"
        />
        <div class="mt-3 d-flex justify-content-center">
            <div 
                v-for="category in categories" 
                :key="category.id"
                class="px-1 py-4"
            >
                <button class="btn btn-outline-success" @click="updateDataSets(category.id)">
                    {{ category.name }}
                </button>
            </div>
        </div>
        <div class="mt-1 d-flex justify-content-center">
            <button class="btn btn-primary" @click="back">
                Back
            </button>
        </div>
    </div>
</template>