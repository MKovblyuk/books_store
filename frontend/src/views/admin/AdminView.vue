<script setup>
import Header from '@/components/managment/Header.vue';
import SideMenu from '@/components/managment/admin/SideMenu.vue';
import { RouterView } from 'vue-router';
</script>

<template>
    <div class="container-fluid">
        <Header/>
        <div class="row align-items-start pt-1">
            <div class="col-2 bg-body-tertiary">
                <SideMenu class="vh-100"></SideMenu>
            </div>
            <div class="col">
                <RouterView name="admin_content"/>
            </div>
        </div>
    </div>
</template>