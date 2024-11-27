<script setup>
import { ref } from 'vue';
import EditBookMetaTab from './EditBookMetaTab.vue';
import EditBookCoverImageTab from './EditBookCoverImageTab.vue';
import EditAudioTab from './EditAudioTab.vue';
import EditElectronicTab from './EditElectronicTab.vue';
import EditPaperTab from './EditPaperTab.vue';
import EditPreviewFragmentsTab from './EditPreviewFragmentsTab.vue';

const props = defineProps(['bookId']);
const emit = defineEmits(['bookUpdated', 'tryReturn']);

const EDIT_META_TAB = 'edit_meta';
const EDIT_COVER_IMAGE = 'edit_cover_image';
const EDIT_AUDIO = 'edit_audio';
const EDIT_ELETRONIC = 'edit_electronic';
const EDIT_PAPER = 'edit_paper';
const EDIT_PREVIEW_FRAGMENTS = 'edit_preview_fragments';
const activeTab = ref(EDIT_META_TAB);

</script>

<template>
    <div>
        <div class="d-flex">
            <button class="btn btn-success" @click="emit('tryReturn')">
                &lArr;
            </button>
            <button class="btn btn-primary ms-2" @click="activeTab = EDIT_META_TAB">
                Edit meta
            </button>
            <button class="btn btn-primary ms-2" @click="activeTab = EDIT_COVER_IMAGE">
                Edit cover image
            </button>
            <button class="btn btn-primary ms-2" @click="activeTab = EDIT_AUDIO">
                Edit Audio
            </button>
            <button class="btn btn-primary ms-2" @click="activeTab = EDIT_ELETRONIC">
                Edit Electonic
            </button>
            <button class="btn btn-primary ms-2" @click="activeTab = EDIT_PAPER">
                Edit Paper
            </button>
            <button class="btn btn-primary ms-2" @click="activeTab = EDIT_PREVIEW_FRAGMENTS">
                Edit Preview Fragments
            </button>
        </div>
        <EditBookMetaTab
            v-if="activeTab === EDIT_META_TAB"
            :book-id="bookId"
            @book-updated="emit('bookUpdated')"
        />
        <EditBookCoverImageTab
            v-if="activeTab === EDIT_COVER_IMAGE"
            :book-id="bookId"
            @book-updated="emit('bookUpdated')"
        />
        <EditAudioTab 
            v-if="activeTab === EDIT_AUDIO"
            :book-id="bookId"
        />
        <EditElectronicTab
            v-if="activeTab === EDIT_ELETRONIC"
            :book-id="bookId"
        />
        <EditPaperTab
            v-if="activeTab === EDIT_PAPER"
            :book-id="bookId"
        />
        <EditPreviewFragmentsTab
            v-if="activeTab === EDIT_PREVIEW_FRAGMENTS"
            :book-id="bookId"
        />
    </div>
</template>