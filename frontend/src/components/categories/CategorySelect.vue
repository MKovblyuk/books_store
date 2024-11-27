<script setup>
import { onMounted, ref } from 'vue';
import UISelect from '../ui/form_components/UISelect.vue';
import axios from 'axios';

const model = defineModel();
const props = defineProps(['errorMessage']);

const categories = ref([]);

onMounted(() => {
    fetchCategoriesFlat();
});

async function fetchCategoriesFlat() {
    const response = await axios.get('categories/flat');
    categories.value = response.data.data;
}

</script>

<template>
    <UISelect
        v-model="model"
        labelText="Categories"
        selectId="categorySelect"
        :items="categories"
        :errorMessage
    />
</template>