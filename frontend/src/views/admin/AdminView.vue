<script setup>
import Header from '@/components/managment/Header.vue';
import SideMenu from '@/components/managment/admin/SideMenu.vue';
import { RouterView } from 'vue-router';
</script>

<template>
    <div>
        <Header/>
        <div class="d-flex pt-1">
            <div class="col-4 col-sm-3 col-md-2 col-xxl-1 bg-body-tertiary px-1">
                <SideMenu class="vh-100"></SideMenu>
            </div>
            <div class="col px-2">
                <RouterView name="admin_content"/>
            </div>
        </div>
    </div>
</template>