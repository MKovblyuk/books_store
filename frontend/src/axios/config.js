import axios from "axios";

axios.defaults.baseURL = import.meta.env.VITE_BASE_API_URL;
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
