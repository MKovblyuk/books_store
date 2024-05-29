<script setup>
import Header from "@/components/Header.vue";
import Footer from "@/components/Footer.vue";

</script>

<template>
    <div class="base">
        <Header/>
        <RouterView name="base_content" class="main"/>
        <Footer/>
    </div>

</template>

<style>
    .base {
        min-height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    .main {
        flex: 1;
    }
</style>
