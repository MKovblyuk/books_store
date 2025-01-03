<script setup>
import BookFileItem from './BookFileItem.vue';
import UIFilesSection from '@/components/ui/sections/UIFilesSection.vue';

const props = defineProps(['files']);
const emit = defineEmits(['delete', 'upload', 'open']);

</script>

<template>
    <UIFilesSection @upload="file => emit('upload', file)">
        <BookFileItem 
            v-for="file in files"
            :file 
            @delete="file => emit('delete', file)"
            @open="file => emit('open', file)"
            class="mt-1"
        />
    </UIFilesSection>
</template>