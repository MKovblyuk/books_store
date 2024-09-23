<script setup>

import AudioBookList from "../lists/AudioBookList.vue";
import axios from "axios";
import { useUserStore } from "@/stores/userStore";
import * as bootstrap from 'bootstrap';
import { onMounted, ref } from "vue";
import MimeTypeExtensions from "@/helpers/MimeTypeExtensions";
import AudioPlayer from "@/components/widgets/AudioPlayer.vue";
import PaginationBar from "@/components/widgets/PaginationBar.vue";
import { useDefaultAssests } from "@/composables/defaultAssets";

const defaultAssets  = useDefaultAssests();
const userStore = useUserStore();
const audioBooks = ref([]);
const isFetched = ref(false);
const meta = ref({});
const PER_PAGE = 1;


const audioPlayerRef = ref(null);
const audioModalRef = ref(null);
const audioSrc = ref('');
const audioPlyaerCoverImageSrc = ref('');

const downloadLinkRef = ref(null);

async function downloadAudioBook(book, extension) {
    try {
        const response = await axios.get('books/audio/' + book.id + '/download/' + extension, { 
            responseType: 'arraybuffer',
        });

        const blob = new Blob([response.data], { type: MimeTypeExtensions.getMimeType(extension) });
        downloadLinkRef.value.href = window.URL.createObjectURL(blob);
        downloadLinkRef.value.download = book.name;
        downloadLinkRef.value.click();
        window.URL.revokeObjectURL(downloadLinkRef.value.href);
  } catch (error) {
    console.error('Error downloading file:', error);
  }
}

async function fetchAudioBooks(page = 1) {
    try {
        const response = await axios.get('users/' + userStore.user.id + '/audioBooks', {
            params: {
                per_page: PER_PAGE,
                page: page
            },
        });
        audioBooks.value = response.data.data;
        meta.value = response.data.meta;
        isFetched.value = true;
    } catch (e) {
        console.log('Error in fetching audio books:', e);
    }
}

async function listenAudioBook(book, extension) {
    try {
        const response = await axios.get('books/audio/' + book.id + '/download/' + extension, { 
            responseType: 'arraybuffer',
        });

        const blob = new Blob([response.data], { type: MimeTypeExtensions.getMimeType(extension) });
        audioSrc.value = window.URL.createObjectURL(blob);
        audioPlyaerCoverImageSrc.value = book.coverImageUrl;

        bootstrap.Modal.getOrCreateInstance(audioModalRef.value).show();
    } catch (error) {
        console.error('Error reading file:', error);
    }
}

onMounted(() => {
    fetchAudioBooks();

    audioModalRef.value.addEventListener('hidden.bs.modal', function () {
        audioPlayerRef.value.player.pause();
    });
});
</script>

<template>
    <section>
        Audio books tab
        <AudioBookList
            :books="audioBooks"
            @listen="listenAudioBook"
            @download="downloadAudioBook"
        />

        <PaginationBar 
            v-if="meta.total > PER_PAGE"
            :meta
            @page_changed="page => fetchAudioBooks(page)"
        />

        <div 
            class="modal"
            id="audioModal" 
            tabindex="-1" 
            aria-labelledby="audioModalLabel"
            ref="audioModalRef"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body audio-body">
                        <AudioPlayer 
                            ref="audioPlayerRef"
                            :audioSrc="audioSrc"
                            :imageSrc="audioPlyaerCoverImageSrc ?? defaultAssets.defaultImageSrc"
                        />
                    </div>
                </div>
            </div>
        </div> 
        
        <a class="visually-hidden" ref="downloadLinkRef"></a>
    </section>
</template>