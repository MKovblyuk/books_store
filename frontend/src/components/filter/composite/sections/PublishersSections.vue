<script setup>
import { defineEmits, onMounted, ref} from "vue";
import { usePublisherStore } from "@/stores/publisherStore";

const model = defineModel();
const publisherStore = usePublisherStore();

onMounted(() => {
    publisherStore.fetchPublishers();
});

</script>

<template>
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
                        :value="publisher.id"
                        v-model="model"
                        :id="`form_check_publisher_${publisher.id}`"
                    >
                    <label class="form-check-label" :for="`form_check_publisher_${publisher.id}`">
                        {{publisher.name}}
                    </label>
                </div>
            </li>
        </ul>
    </section>
</template>