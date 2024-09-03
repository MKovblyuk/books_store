import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";


export const usePublisherStore = defineStore('publisher', () => {
    const publishers = ref([]);
    const isFetched = ref(false);

    async function fetchPublishers() {
        if (!isFetched.value) {
            const response = await axios.get('/publishers');
            publishers.value = response.data.data;
            isFetched.value = true;
        }
    }

    return {publishers, isFetched, fetchPublishers}
});