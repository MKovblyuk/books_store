import { defineStore } from "pinia";
import { ref } from "vue";

export const useUserStore = defineStore('user', () => {
    // const token = ref();

    function getToken()
    {
        localStorage.getItem('user_token');
    }

    function setToken(token)
    {
        localStorage.setItem('user_token', token);
    }

    // remove in future
    const tmp_auth_status = ref(true);

    function isAuthorized()
    {
        // console.log(getToken());
        return tmp_auth_status.value;
    }

    function logout() 
    {
        localStorage.removeItem('user_token');

        tmp_auth_status.value = false;
        console.log('successfully logged out');
    }

    return {getToken, setToken, isAuthorized, logout, tmp_auth_status}
});