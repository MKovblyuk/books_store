import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";


export const useLanguageStore = defineStore('language', () => {
    const languages = ref([]);
    const isFetched = ref(false);

    async function fetchLanguages() {
        if (!isFetched.value) {
            const response = await axios.get('books/languages');
            languages.value = response.data.data;
            isFetched.value = true;
        }
    }

    return {languages, isFetched, fetchLanguages}
});