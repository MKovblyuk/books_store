<script setup>
import { BookFormats } from "@/enums/bookFormats";

const model = defineModel();

</script>

<template>
    <section class="filter_section">
        <div class="section_title">
            Book Types
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="form_check_paper"
                        :value="BookFormats.Paper"
                        v-model="model"
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
                        id="form_check_electronic"
                        :value="BookFormats.Electronic"
                        v-model="model"
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
                        id="form_check_audio"
                        :value="BookFormats.Audio"
                        v-model="model"
                    >
                    <label class="form-check-label" for="form_check_audio">
                        Audio
                    </label>
                </div>
            </li>
        </ul>
    </section>
</template>