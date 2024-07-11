import { defineStore } from "pinia";
import { ref } from "vue";


export const useFilterStore = defineStore('filter', () => {
    // const languages = ref([]);

    // const addLanguage = (language) => {

    // }

    // const removeLanguage = (language) => {

    // }

    const options = ref({
        book_types: [],
        publishers: [],
        authors: [],
        languages: [],
        formats: [],
        price_from: null,
        price_to: null,
    });

    const addOptionValue = (name, value) => options.value[name].push(value);
    

    const removeOptionValue = (name, value) => {
        const index = options.value[name].indexOf(value);
        if (index > -1) {
            options.value[name].splice(index,1);
        }
    }

    const setPriceFrom = (value) => {
        if (value > 0) {
            options.value.price_from = value;
        }
    }

    const setPriceTo = (value) => {
        if (value > 0) {
            options.value.price_to = value;
        }
    }

    const setPrices = (from, to) => {
        setPriceFrom(from);
        setPriceTo(to);
    }

    const getPriceFrom = () => options.value.price_from;

    const getPriceTo = () => options.value.price_to;

    const isCheckedOptionValue = (name, value) => {
        // console.log('try check');
        // console.log('arr = ', options.value[name]);
        // console.log('index = ', options.value[name].indexOf(value));
        // console.log('name = ', name);
        // console.log('value = ', value);
        // console.log(options.value[name].indexOf(value) > -1);


        return options.value[name].indexOf(value) > -1
    }

    
    return {
        options, 
        addOptionValue, 
        removeOptionValue, 
        isCheckedOptionValue,
        setPriceFrom,
        setPriceTo,
        getPriceFrom,
        getPriceTo,
        setPrices,
    };
});