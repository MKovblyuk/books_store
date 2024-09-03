import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";


export const useAuthorStore = defineStore('author', () => {
    const authors = ref([]);
    const isFetched = ref(false);

    async function fetchAuthors() {
        if (!isFetched.value) {
            const response = await axios.get('/authors');
            authors.value = response.data.data;
            isFetched.value = true;
        }
    }

    return {authors, isFetched, fetchAuthors}
});