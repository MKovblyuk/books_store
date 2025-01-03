<script setup>
import UIFilesSection from '@/components/ui/sections/UIFilesSection.vue';
import BookFragmentItem from './BookFragmentItem.vue';
import { useEditPreviewFragments } from '@/composables/editPreviewFragments';
import UIErrorsList from '@/components/ui/sections/UIErrorsList.vue';

const props = defineProps(['bookId']);

const {
    previewFragments,
    errors,
    addFragment,
    deleteFragment,
    fetchPreviewFragments
} = useEditPreviewFragments(props.bookId); 

function handleUpload(fragment) {
    addFragment(fragment).then(() => fetchPreviewFragments());
}

function handleDelete(fragment) {
    deleteFragment(fragment).then(() => fetchPreviewFragments());
}

function openFragment(fragment) {

}

</script>

<template>
    <div>
        <UIErrorsList
            class="mt-3 mb-1"
            :errors
        />
        <UIFilesSection @upload="handleUpload">
            <BookFragmentItem
                v-for="fragment in previewFragments"
                :fragment
                :key="fragment.id"
                @delete="handleDelete"
                @open="openFragment"
            />
        </UIFilesSection>
    </div>
</template>