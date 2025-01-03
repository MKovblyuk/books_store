<script setup>
import { ref } from 'vue';

const props = defineProps(['show', 'title', 'inputId', 'slotClass']);
const emit = defineEmits(['change']);

const show = ref(props.show ?? false);

</script>

<template>
    <div>
        <div class="form-check">
            <input 
                class="form-check-input" 
                type="checkbox" 
                :id="inputId"
                v-model="show"
                @change="e => emit('change', e)"
            >
            <label 
                class="form-check-label" 
                :for="inputId"
            >
                {{ title }}
            </label>
        </div>
        <div v-show="show" :class="slotClass">
            <slot></slot>
        </div>
    </div>
</template>