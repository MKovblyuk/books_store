import { defineStore } from "pinia";
import { ref } from "vue";

export const useSortingStore = defineStore('sorting', () => {
    const SELLING_COUNT = '-selling_count';
    const LIKES = '-likes';
    const PRICE = 'price';
    const PRICE_DESC = '-price';

    const param = ref(SELLING_COUNT);

    return {
        param,
        SELLING_COUNT,
        LIKES,
        PRICE,
        PRICE_DESC
    };
});