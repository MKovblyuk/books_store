<script setup>
import CompositeFilter from './CompositeFilter.vue';
import AuthorsSection from './sections/AuthorsSection.vue';
import BookTypesSection from './sections/BookTypesSection.vue';
import LanguagesSection from './sections/LanguagesSection.vue';
import PriceSection from './sections/PriceSection.vue';
import PublishersSections from './sections/PublishersSections.vue';

const emit = defineEmits(['filter_options_changed'])

const bookTypes = defineModel('bookTypes');
const publishers = defineModel('publishers');
const authors = defineModel('authors');
const languages = defineModel('languages');
const priceFrom = defineModel('priceFrom');
const priceTo = defineModel('priceTo');

</script>

<template>
    <CompositeFilter>
        <BookTypesSection v-model="bookTypes"/>
        <PublishersSections v-model="publishers"/>
        <AuthorsSection v-model="authors"/>
        <LanguagesSection v-model="languages"/>
        <PriceSection 
            v-model:price-from="priceFrom"
            v-model:price-to="priceTo"
            @filter_options_changed="(from, to) => emit('filter_options_changed', from, to)"    
        />
    </CompositeFilter>
</template>