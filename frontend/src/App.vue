<script setup>
import { RouterView } from 'vue-router'
import { useUserStore } from './stores/userStore';
import { onMounted } from 'vue';

const userStore = useUserStore();

onMounted(() => {
    userStore.fetchUser();
});

</script>

<template>
    <RouterView name="main_pages"/>
    <RouterView name="managment_pages"/>
</template>

<style>
@import "@/assets/base.css";
</style>
