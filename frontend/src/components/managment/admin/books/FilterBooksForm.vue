<script setup>
import { ref } from 'vue';
import ToggleSection from '@/components/widgets/ToggleSection.vue';
import PublishersSections from '@/components/filter/composite/sections/PublishersSections.vue';
import AuthorsSection from '@/components/filter/composite/sections/AuthorsSection.vue';
import LanguagesSection from '@/components/filter/composite/sections/LanguagesSection.vue';
import BookTypesSection from '@/components/filter/composite/sections/BookTypesSection.vue';

const emit = defineEmits(['filterChanged']);

const searchBookData = ref({
    publishers: [],
    authors: [],
    languages: [],
    bookFormats: [],
    categories: [],
});

function reset() {
    searchBookData.value = {
        publishers: [],
        authors: [],
        languages: [],
        bookFormats: [],
        categories: [],
    };
    emit('filterChanged', searchBookData.value);
}

</script>

<template>
    <div>
        <div class="mb-3">
            <label for="idInput" class="form-label">
                Id
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="idInput"
                v-model="searchBookData.id"
            >
        </div>
        <div class="mb-3">
            <label for="nameInput" class="form-label">
                Name
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="nameInput"
                v-model="searchBookData.name"
            >
        </div>
        <div class="mb-3">
            <label for="publicationYearInput" class="form-label">
                Publication year
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="publicationYearInput"
                v-model="searchBookData.publicationYear"
            >
        </div>
        <div class="mb-3">
            <ToggleSection btn-text="Publishers">
                <PublishersSections v-model="searchBookData.publishers"/>
            </ToggleSection>

            <ToggleSection btn-text="Authors" class="mt-1">
                <AuthorsSection v-model="searchBookData.authors"/>
            </ToggleSection>

            <ToggleSection btn-text="Languages" class="mt-1">
                <LanguagesSection v-model="searchBookData.languages"/>
            </ToggleSection>

            <ToggleSection btn-text="Book types" class="mt-1">
                <BookTypesSection v-model="searchBookData.bookFormats"/>
            </ToggleSection>
        </div>
        <div class="mb-3">
            <label class="form-label">
                Price Range
            </label>
            <div>
                <label>From</label>
                <input 
                    class="w-100 mb-2" 
                    type="number" 
                    placeholder="From"
                    v-model="searchBookData.priceFrom"
                >

                <label>To</label>
                <input 
                    class="w-100 mb-4" 
                    type="number" 
                    placeholder="To"
                    v-model="searchBookData.priceTo"
                >
            </div>
        </div>
        <div class="mb-3">
            <label for="createdAtInput" class="form-label">
                Created At
            </label>
            <input 
                type="date" 
                class="form-control" 
                id="createdAtInput"
                v-model="searchBookData.createdAt"
            >
        </div>
        <div class="mb-3">
            <label for="updatedAtInput" class="form-label">
                Updated At
            </label>
            <input 
                type="date" 
                class="form-control" 
                id="updatedAtInput"
                v-model="searchBookData.updatedAt"
            >
        </div>
        <div>
            <button class="btn btn-primary me-1" @click="reset">
                Reset
            </button>
            <button class="btn btn-primary" @click="emit('filterChanged', searchBookData)">
                Search
            </button>
        </div>
    </div>
</template>