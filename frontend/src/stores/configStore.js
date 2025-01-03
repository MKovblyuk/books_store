import { defineStore } from "pinia";
import { ref } from "vue";

export const useConfigStore = defineStore('config', () => {
    const locale = ref('uk-UA')

    return {locale}
});