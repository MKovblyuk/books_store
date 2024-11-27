import axios from "axios";
import { ref } from "vue";

export const useEditBookFormatFiles = (bookId, format) => {
    const fileErrors = ref([]);

    async function deleteFile(file) {
        try {
            fileErrors.value = [];
            await axios.delete(`/books/${format}/${bookId}/${file.extension}`);
        } catch(e) {
            if (e.response.status === 422) {
                fileErrors.value.push(e.response.data?.erros);
            }
            if (e.response.status === 404 || e.response.status === 400) {
                fileErrors.value.push(e.response.data?.message);
            }
        }
    }

    async function uploadFile(file) {
        try {
            fileErrors.value = [];
    
            await axios.post(`/books/upload/${format}`, {
                'bookId': bookId,
                'files[]': file
            }, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
        } catch(e) {
            if (e.response.status === 422) {
                fileErrors.value.push(e.response.data?.errors);
                fileErrors.value.push(e.response.data?.message);
            }
        }
    }

    return {fileErrors, uploadFile, deleteFile};
}