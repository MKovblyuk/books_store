<script setup>
import { usePublisherStore } from '@/stores/publisherStore';
import UISelect from '../ui/form_components/UISelect.vue';
import { onMounted } from 'vue';

const model = defineModel();
const props = defineProps(['errorMessage']);

onMounted(() => {
    usePublisherStore().fetchPublishers();
});

</script>

<template>
    <UISelect
        v-model="model"
        labelText="Publishers"
        selectId="publisherSelect"
        :items="usePublisherStore().publishers"
        :errorMessage
    />
</template>