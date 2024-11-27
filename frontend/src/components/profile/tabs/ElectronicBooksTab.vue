<script setup>

import ElectronicBookList from "../lists/ElectronicBookList.vue";
import { useUserStore } from "@/stores/userStore";
import axios from "axios";
import { onMounted, ref } from "vue";
import PaginationBar from "@/components/widgets/PaginationBar.vue";
import { useElectronicBook } from "@/composables/electronicBook";

const userStore = useUserStore();
const electronicBooks = ref([]);
const isFetched = ref(false);
const meta = ref({});
const PER_PAGE = 1;

const {openLinkRef, downloadLinkRef, openBook, downloadBook} = useElectronicBook();

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
            @read="(book,ext) => openBook(book.id, ext)"
            @download="(book,ext) => downloadBook(book.id, ext, book.name)"
        />

        <PaginationBar 
            v-if="meta.total > PER_PAGE"
            :meta
            @page_changed="page => fetchElectronicBooks(page)"
        />

        <a class="visually-hidden" ref="openLinkRef"></a>
        <a class="visually-hidden" ref="downloadLinkRef"></a>
    </section>
</template>