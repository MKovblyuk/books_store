<script setup>
import { defineEmits, onMounted, ref} from "vue";
import { useAuthorStore } from "@/stores/authorStore";

const authorStore = useAuthorStore();
const model = defineModel();

onMounted(() => {
    authorStore.fetchAuthors();
});

</script>

<template>
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
                        v-model="model"
                    >
                    <label class="form-check-label" :for="`form_check_author_${author.id}`">
                        {{author.firstName + " " + author.lastName}}
                    </label>
                </div>
            </li>
        </ul>
    </section>
</template>