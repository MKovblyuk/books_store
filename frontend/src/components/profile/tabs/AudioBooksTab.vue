<script setup>

import AudioBookList from "../lists/AudioBookList.vue";
import axios from "axios";
import { useUserStore } from "@/stores/userStore";
import * as bootstrap from 'bootstrap';
import { onMounted, ref } from "vue";
import AudioPlayer from "@/components/widgets/AudioPlayer.vue";
import PaginationBar from "@/components/widgets/PaginationBar.vue";
import { useDefaultAssests } from "@/composables/defaultAssets";
import { useAudioBook } from "@/composables/audioBook";
import ShowModal from "@/components/widgets/modals/ShowModal.vue";

const defaultAssets  = useDefaultAssests();
const userStore = useUserStore();
const audioBooks = ref([]);
const isFetched = ref(false);
const meta = ref({});
const PER_PAGE = 20;

const audioPlayerRef = ref(null);
const audioModalRef = ref(null);
const audioPlyaerCoverImageSrc = ref('');
const {audioSrc, downloadLinkRef, downloadBook, openBook} = useAudioBook();

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
    audioPlyaerCoverImageSrc.value = book.coverImageUrl;
    openBook(book.id, extension)
        .then(() => bootstrap.Modal.getOrCreateInstance(audioModalRef.value.modal).show());
}

onMounted(() => {
    fetchAudioBooks();

    audioModalRef.value.modal.addEventListener('hidden.bs.modal', function () {
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
            @download="(book, ext) => downloadBook(book.id, ext, book.name)"
        />

        <PaginationBar 
            v-if="meta.total > PER_PAGE"
            :meta
            @page_changed="page => fetchAudioBooks(page)"
        />

        <ShowModal id="audioModal" ref="audioModalRef">
            <AudioPlayer 
                ref="audioPlayerRef"
                :audioSrc="audioSrc"
                :imageSrc="audioPlyaerCoverImageSrc ?? defaultAssets.defaultImageSrc"
            />
        </ShowModal>
        
        <a class="visually-hidden" ref="downloadLinkRef"></a>
    </section>
</template>