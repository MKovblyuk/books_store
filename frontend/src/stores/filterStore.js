import { defineStore } from "pinia";
import { computed, ref } from "vue";


export const useFilterStore = defineStore('filter', () => {
    const publishers = ref([]);
    const authors = ref([]);
    const languages = ref([]);
    const formats = ref([]);
    const priceFrom = ref();
    const priceTo = ref();
    const bookName = ref();
    const category = ref();

    const setPriceFrom = (value) => {
        if (value < 0) {
            throw new Error('Value should be > 0');
        }

        priceFrom.value = value;
    }

    const setPriceTo = (value) => {
        if (value < 0) {
            throw new Error('Value should be > 0');
        }

        priceTo.value = value;
    }

    const setPrices = (from, to) => {
        setPriceFrom(from);
        setPriceTo(to);
    }

    const queryParamsObject = computed(() => {
        let priceRangeParam = priceFrom.value;

        if (priceTo.value != null && priceTo.value != '') {
            priceFrom.value != null && priceFrom.value != ''
                ? priceRangeParam = priceFrom.value + ',' + priceTo.value
                : priceRangeParam = '0,' + priceTo.value;
        }

        const params = {
            "filter[language]": languages.value?.join(','),
            "filter[publisher_id]": publishers.value?.join(','),
            "filter[author_id]": authors.value?.join(','),
            "filter[format]": formats.value?.join(','),
            "filter[price_range]": priceRangeParam,
            "filter[name]": bookName.value,
            "filter[category_id]": category.value,
        };

        return Object.fromEntries(Object.entries(params).filter(([key, value]) => value != null && value !== ""));
    })
    
    return {
        publishers,
        authors,
        languages,
        formats,
        priceFrom,
        priceTo,
        setPriceFrom,
        setPriceTo,
        setPrices,
        queryParamsObject,
        bookName,
        category,
    };
});