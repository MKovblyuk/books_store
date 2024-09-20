<script setup>
import { ref } from "vue";
import ElectronicBooksTab from "@/components/profile/tabs/ElectronicBooksTab.vue";
import AudioBooksTab from "@/components/profile/tabs/AudioBooksTab.vue";
import OrderHistoryTab from "@/components/profile/tabs/OrderHistoryTab.vue";
import LikedBooksTab from "@/components/profile/tabs/LikedBooksTab.vue";
import InfoTab from "@/components/profile/tabs/InfoTab.vue";


const INFO = 'info';
const ELECTRONIC_BOOKS = 'electronic_books';
const AUDIO_BOOKS = 'audio_books';
const ORDER_HISTORY = 'order_history';
const LIKED_BOOKS = 'liked_books';

const activeTab = ref(INFO);

</script>

<template>
    <div>
        <div class="tab_buttons">
            <button @click="activeTab=INFO" class="btn btn-success me-1">Info</button>
            <button @click="activeTab=ELECTRONIC_BOOKS" class="btn btn-success me-1">Electronic Books</button>
            <button @click="activeTab=AUDIO_BOOKS" class="btn btn-success me-1">Audio Books</button>
            <button @click="activeTab=ORDER_HISTORY" class="btn btn-success me-1">Order history</button>
            <button @click="activeTab=LIKED_BOOKS" class="btn btn-success">Liked books</button>
        </div>
        
        <InfoTab v-if="activeTab===INFO"/>
        <ElectronicBooksTab v-if="activeTab===ELECTRONIC_BOOKS"/>
        <AudioBooksTab v-if="activeTab===AUDIO_BOOKS"/>
        <OrderHistoryTab v-if="activeTab===ORDER_HISTORY"/>
        <LikedBooksTab v-if="activeTab===LIKED_BOOKS"/>
    </div>
</template>

<style scoped>
    .profile_form {
        margin: 0 auto;
        width: 50%;
    }
    .tab_buttons {
        display: flex;
        justify-content: center;
        margin: 10px 0;
    }
</style>