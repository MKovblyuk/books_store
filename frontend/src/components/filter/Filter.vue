<script setup>
import { defineEmits, onMounted} from "vue";
import { BookFormats } from "@/enums/bookFormats";
import { useFilterStore } from "@/stores/filterStore";
import { usePublisherStore } from "@/stores/publisherStore";
import { useAuthorStore } from "@/stores/authorStore";
import { useLanguageStore } from "@/stores/languageStore";

const emit = defineEmits(['filter_options_changed']);

const filterStore = useFilterStore();
const publisherStore = usePublisherStore();
const authorStore = useAuthorStore();
const languageStore = useLanguageStore();

onMounted(() => {
    publisherStore.fetchPublishers();
    authorStore.fetchAuthors();
    languageStore.fetchLanguages();
});

</script>

<template>
    <div class="p-2">
        <hr>
        <h5>Filtering</h5>
        <hr>

        <section class="filter_section">
            <div class="section_title">
                Book Type
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="form_check_paper"
                            name="formats"
                            :value="BookFormats.Paper"
                            v-model="filterStore.formats"
                            @change="$emit('filter_options_changed')"
                        >
                        <label class="form-check-label" for="form_check_paper">
                            Paper
                        </label>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="form-check">
                        <input 
                            class="form-check-input"    
                            type="checkbox" 
                            :value="BookFormats.Electronic" 
                            id="form_check_electronic"
                            name="formats"
                            v-model="filterStore.formats"
                            @change="$emit('filter_options_changed')"
                        >
                        <label class="form-check-label" for="form_check_electronic">
                            Electronic
                        </label>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            :value="BookFormats.Audio" 
                            id="form_check_audio"
                            name="formats"
                            v-model="filterStore.formats"
                            @change="$emit('filter_options_changed')"
                        >
                        <label class="form-check-label" for="form_check_audio">
                            Audio
                        </label>
                    </div>
                </li>
            </ul>
        </section>

        <section class="filter_section">
            <div class="section_title">
                Publishers
            </div>
            <ul class="list-group list-group-flush">
                <li v-for="publisher in publisherStore.publishers" :key="publisher.id" class="list-group-item">
                    <div  class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            :id="`form_check_publisher_${publisher.id}`"
                            :value=publisher.id
                            name="publishers"
                            v-model="filterStore.publishers"
                            @change="$emit('filter_options_changed')"
                        >
                        <label class="form-check-label" :for="`form_check_publisher_${publisher.id}`">
                            {{publisher.name}}
                        </label>
                    </div>
                </li>
            </ul>
        </section>

        <section class="filter_section">
            <div class="section_title">
                Authors
            </div>
            <ul class="list-group list-group-flush">
                <li v-for="author in authorStore.authors" :key="author.id" class="list-group-item">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            :id="`form_check_author_${author.id}`"
                            :value="author.id"
                            name="authors"
                            v-model="filterStore.authors"
                            @change="$emit('filter_options_changed')"
                        >
                        <label class="form-check-label" :for="`form_check_author_${author.id}`">
                            {{author.firstName + " " + author.lastName}}
                        </label>
                    </div>
                </li>
            </ul>
        </section>

        <section class="filter_section">
            <div class="section_title">
                Language
            </div>
            <ul class="list-group list-group-flush">
                <li v-for="i in languageStore.languages.length" class="list-group-item">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            :value="languageStore.languages[i-1]" 
                            :id="`form_check_language_${languageStore.languages[i-1]}`"
                            name="languages"
                            v-model="filterStore.languages"
                            @change="$emit('filter_options_changed')"
                        >
                        <label class="form-check-label" :for="`form_check_language_${languageStore.languages[i-1]}`">
                            {{languageStore.languages[i-1]}}
                        </label>
                    </div>
                </li>
            </ul>
        </section>

        <section class="filter_section">
            <div class="section_title">
                Price
            </div>
            <div>
                <label>From</label>
                <input 
                    class="w-100 mb-2" 
                    type="number" 
                    placeholder="From"
                    :value="filterStore.priceFrom"
                    @input="$event.target.value >= 0 && filterStore.setPriceFrom($event.target.value)"
                >

                <label>To</label>
                <input 
                    class="w-100 mb-4" 
                    type="number" 
                    placeholder="To"
                    :value="filterStore.priceTo"
                    @input="$event.target.value >= 0 && filterStore.setPriceTo($event.target.value)"
                >
                <button 
                    class="btn btn-primary w-100" 
                    @click="$emit('filter_options_changed')"
                >
                    Apply
                </button>
            </div>
        </section>
    </div>
</template>

<style scoped>
.section_title {
    font-weight: bold;
    margin-bottom: .4rem;
}
.filter_section {
    margin-bottom: 10px;
}

.list-group{
    max-height: 300px;
    margin-bottom: 10px;
    overflow-x: hidden;
}

.list-group-item{
    border-bottom: none;
    padding: .125rem;
}

</style>