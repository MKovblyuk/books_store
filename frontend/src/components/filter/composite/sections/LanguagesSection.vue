<script setup>
import { defineEmits, onMounted } from "vue";
import { useLanguageStore } from "@/stores/languageStore";

const languageStore = useLanguageStore();
const model = defineModel();

onMounted(() => {
    languageStore.fetchLanguages();
});

</script>

<template>
    <section class="filter_section">
        <div class="section_title">
            Languages
        </div>
        <ul class="list-group list-group-flush">
            <li v-for="i in languageStore.languages.length" class="list-group-item">
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        :value="languageStore.languages[i-1]"
                        v-model="model"
                        :id="`form_check_language_${languageStore.languages[i-1]}`"
                    >
                    <label class="form-check-label" :for="`form_check_language_${languageStore.languages[i-1]}`">
                        {{languageStore.languages[i-1]}}
                    </label>
                </div>
            </li>
        </ul>
    </section>
</template>