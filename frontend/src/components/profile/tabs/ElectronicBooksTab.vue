<script setup>

import ElectronicBookList from "../lists/ElectronicBookList.vue";
import { useUserStore } from "@/stores/userStore";
import axios from "axios";
import { onMounted, ref } from "vue";
import MimeTypeExtensions from "@/helpers/MimeTypeExtensions";
import PaginationBar from "@/components/widgets/PaginationBar.vue";

const userStore = useUserStore();
const electronicBooks = ref([]);
const isFetched = ref(false);
const meta = ref({});
const PER_PAGE = 1;

const readLinkRef = ref(null);
const downloadLinkRef = ref(null);

async function readElectronicBook(book, extension) {
    try {
        const response = await axios.get('/books/electronic/' + book.id + '/download/' + extension, { 
            responseType: 'arraybuffer',
        });

        const blob = new Blob([response.data], { type: MimeTypeExtensions.getMimeType(extension) });
        readLinkRef.value.href = window.URL.createObjectURL(blob);
        readLinkRef.value.target="_blank";
        readLinkRef.value.click();
        window.URL.revokeObjectURL(readLinkRef.value.href);
    } catch (error) {
    console.error('Error reading file:', error);
    }
}

async function downloadElectronicBook(book, extension) {
    try {
        const response = await axios.get('/books/electronic/' + book.id + '/download/' + extension, { 
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

async function fetchElectronicBooks(page = 1) {
    try {
        const response = await axios.get('users/' + userStore.user.id + '/electronicBooks', {
            params: {
                per_page: PER_PAGE,
                page,
            }
        });
        electronicBooks.value = response.data.data;
        meta.value = response.data.meta;
        isFetched.value = true;
    } catch (e) {
        console.log('Error in fetching electronic books:', e);
    }
}

onMounted(() => {
    fetchElectronicBooks();
});

</script>

<template>
    <section>
        Electronic books tab 
        
        <ElectronicBookList 
            :books="electronicBooks"
            @read="readElectronicBook"
            @download="downloadElectronicBook"
        />

        <PaginationBar 
            v-if="meta.total > PER_PAGE"
            :meta
            @page_changed="page => fetchElectronicBooks(page)"
        />

        <a class="visually-hidden" ref="readLinkRef"></a>
        <a class="visually-hidden" ref="downloadLinkRef"></a>
    </section>
</template>