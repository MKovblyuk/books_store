<script setup>
import AdditionalInfoTab from '@/components/managment/admin/orders/AdditionalInfoTab.vue';
import BaseInfoTab from '@/components/managment/admin/orders/BaseInfoTab.vue';
import { ref } from 'vue';

const BASE_INFO = 'base_info';
const ADDITIONAL_INFO = 'additional_info';

const activeTab = ref(BASE_INFO);

</script>

<template>
    <div>
        <nav class="nav nav-pills nav-fill mb-2">
            <button 
                class="nav-link" :class="activeTab === BASE_INFO ? 'active' : ''" 
                @click="activeTab=BASE_INFO"
            >
                Base Info
            </button>
            <button 
                class="nav-link" :class="activeTab === ADDITIONAL_INFO ? 'active' : ''" 
                @click="activeTab=ADDITIONAL_INFO"
            >
                Additional Info
            </button>
        </nav>

        <BaseInfoTab v-if="activeTab === BASE_INFO"/>
        <AdditionalInfoTab v-if="activeTab === ADDITIONAL_INFO"/>
    </div>
</template>