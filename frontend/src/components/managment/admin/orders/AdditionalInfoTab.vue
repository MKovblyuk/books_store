<script setup>
import { ref } from 'vue';
import OrdersCreationTab from './OrdersCreationTab.vue';
import PopularCategoriesTab from './PopularCategoriesTab.vue';
import PopularBookFormatsTab from './PopularBookFormatsTab.vue';

const ORDERS_CREATION_TAB = 'orders_creation_tab';
const POPULAR_CATEGORIES_TAB = 'popular_categories_tab';
const POPULAR_FORMATS_TAB = 'popular_formats_tab';

const activeTab = ref(ORDERS_CREATION_TAB);

</script>

<template>
    <div>
        <nav class="nav nav-pills nav-fill mb-2 mt-3">
            <button 
                class="nav-link" :class="activeTab === ORDERS_CREATION_TAB ? 'active' : ''" 
                @click="activeTab=ORDERS_CREATION_TAB"
            >
                Orders creation
            </button>
            <button 
                class="nav-link" :class="activeTab === POPULAR_CATEGORIES_TAB ? 'active' : ''" 
                @click="activeTab=POPULAR_CATEGORIES_TAB"
            >
                Popular categories
            </button>
            <button 
                class="nav-link" :class="activeTab === POPULAR_FORMATS_TAB ? 'active' : ''" 
                @click="activeTab=POPULAR_FORMATS_TAB"
            >
                Popular book formats
            </button>
        </nav>

        <OrdersCreationTab v-if="activeTab === ORDERS_CREATION_TAB"/>
        <PopularCategoriesTab v-if="activeTab === POPULAR_CATEGORIES_TAB"/>
        <PopularBookFormatsTab v-if="activeTab === POPULAR_FORMATS_TAB"/>
    </div>
</template>