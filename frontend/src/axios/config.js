import axios from "axios";

axios.defaults.baseURL = 'http://localhost/api/v1/';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
