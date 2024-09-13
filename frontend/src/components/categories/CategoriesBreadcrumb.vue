<script setup>
import { useCategoryStore } from '@/stores/categoryStore';

const props = defineProps(['category']);
const emit = defineEmits(['category_changed']);

</script>

<template>
    <nav v-if="category" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="p-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="#" @click="$emit('category_changed', null)">
                    All
                </a>
            </li>
            <li 
                v-for="category in useCategoryStore().getParentsById(category.id).toReversed()"
                class="breadcrumb-item"
                :key="category.id"
            >
                <a href="#" @click="$emit('category_changed', category.id)">
                    {{ category.name }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ category.name }}
            </li>
        </ol>
    </nav>
</template>