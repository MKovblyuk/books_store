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
        const response = await axios.get('users/' + userId, {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('userToken')
            }
        })

        user.value = response.data.data;
        loading.value = false;

        authorized.value = true;
    }

    // const login = async () => {
    //     const response = await axios.post('http://localhost/api/login', loginData.value);

    //     localStorage.setItem('userId', response.data.userId);
    //     localStorage.setItem('userToken', response.data.token);
    // }

    function logout() 
    {
        localStorage.removeItem('userToken');
        localStorage.removeItem('userId');

        authorized.value = false;
        user.value = null;
    }

    return {logout, fetchUser, user, authorized}
});