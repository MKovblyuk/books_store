import './assets/main.css'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"


import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import {createPinia} from "pinia";
import '@/axios/config';


const app = createApp(App)

app.use(createPinia());
app.use(router)

app.mount('#app')
