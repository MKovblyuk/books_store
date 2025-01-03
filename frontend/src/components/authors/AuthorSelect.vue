<script setup>
import { useAuthorStore } from '@/stores/authorStore';
import UISelect from '../ui/form_components/UISelect.vue';
import { onMounted, ref } from 'vue';

const model = defineModel();
const props = defineProps(['errorMessage', 'multiple']);
const authors = ref([]);

onMounted(() => {
    useAuthorStore().fetchAuthors();
    authors.value = useAuthorStore().authors
        .map(a => ({id: a.id, name: a.firstName + ' ' + a.lastName}));
});

</script>

<template>
    <UISelect
        v-model="model"
        labelText="Authors"
        selectId="authorSelect"
        :items="authors"
        :errorMessage
        :multiple
    />
</template>