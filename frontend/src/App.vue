<script setup>
import { RouterView } from 'vue-router'
import { useUserStore } from './stores/userStore';
import { onMounted } from 'vue';

const userStore = useUserStore();

const tryAuthorize = () => {
    if(localStorage.getItem('userToken') && localStorage.getItem('userId')) {
        userStore.fetchUser();
    }
}

onMounted(() => {
    tryAuthorize();
});

</script>

<template>
    <RouterView name="main_pages"/>
</template>

<style>
@import "@/assets/base.css";
</style>
