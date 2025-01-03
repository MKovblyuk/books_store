<script setup>
import { defineEmits } from "vue";

const emit = defineEmits(['filter_options_changed']);
const priceFrom = defineModel('priceFrom');
const priceTo = defineModel('priceTo');

</script>

<template>
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
                v-model="priceFrom"
            >

            <label>To</label>
            <input 
                class="w-100 mb-4" 
                type="number" 
                placeholder="To"
                v-model="priceTo"
            >
            <button 
                class="btn btn-primary w-100" 
                @click="emit('filter_options_changed', priceFrom, priceTo)"
            >
                Apply
            </button>
        </div>
    </section>
</template>