import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useUserStore = defineStore('user', () => {
    const user = ref();
    const loading = ref(false);
    const authorized = ref(false);


    const fetchUser = async () => {
        loading.value = true;

        const userId = localStorage.getItem('userId');
        const response = await axios.get('users/' + userId);

        user.value = response.data.data;
        loading.value = false;

        authorized.value = true;
    }

    async function login (credentials) {
        const response = await axios.post('http://localhost/api/login', credentials);

        localStorage.setItem('userId', response.data.userId);
        fetchUser();
    }

    async function logout() 
    {
        const response = await axios.post('http://localhost/api/logout');
        localStorage.removeItem('userId');


        authorized.value = false;
        user.value = null;
    }

    return {logout, fetchUser, login, user, authorized}
});