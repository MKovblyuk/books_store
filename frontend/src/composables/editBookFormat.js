import axios from "axios";
import { onMounted, ref } from "vue";

export const useEditBookFormat = (bookId, format, formatDataIni = {}) => {
    const formatNotFound = ref(false);
    const formatData = ref(formatDataIni);
    const errors = ref([]);

    onMounted(() => {
        fetchFormat();
    });

    async function fetchFormat() {
        try {
            formatNotFound.value = false;
            const response = await axios.get(`books/${bookId}/${format}`);
            formatData.value = response.data.data;
        } catch(e) {
            if (e.response?.status === 404) {
                formatNotFound.value = true;
            }
        }
    }

    async function updateFormat() {
        try {
            errors.value = [];
            const data = {...formatData.value};
            delete data.files;

            const response = await axios.patch(`${format}Formats/${formatData.value.id}`, data);

            if (response.status === 200) {
                alert('Updated');
            }
        } catch(e) {
            if (e.response.status === 422) {
                errors.value = e.response.data?.errors?.formats;
            }
            console.log(e);
        }
    }

    async function storeFormat(data) {
        try {
            errors.value = [];
            const response = await axios.post(`${format}Formats/${bookId}`, data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            if (response.status === 201) {
                alert('Created');
            }
        } catch(e) {
            if (e.response.status === 422) {
                errors.value = e.response.data?.errors ?? [];
                errors.value.push(e.response.data?.errors?.['files.0']);
            }
            console.log(e);
        }
    }

    async function deleteFormat() {
        const response = await axios.delete(`${format}Formats/${formatData.value.id}`);
        if (response.status === 204) {
            formatNotFound.value = true;
        }
    }
    
    return {
        formatNotFound, formatData, errors, fetchFormat, updateFormat, storeFormat, deleteFormat
    }
}