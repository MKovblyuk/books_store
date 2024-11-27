import axios from "axios";
import { onMounted, ref } from "vue";

export const useEditPreviewFragments = (bookId) => {
    const previewFragments = ref([]);
    const errors = ref([]);

    onMounted(() => {
        fetchPreviewFragments();
    })

    async function fetchPreviewFragments() {
        const response = await axios.get(`/books/${bookId}/fragments`);
        previewFragments.value = response.data.data;
    }
    
    async function addFragment(fragment) {
        try {
            const response = await axios.post('/fragments', {
                bookId,
                file: fragment 
            }, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
        } catch(e) {
            if (e.response.status = 422) {
                errors.value = e.response.data?.errors;
            }
        }
    }
    
    async function deleteFragment(fragment) {
        await axios.delete(`fragments/${fragment.id}`);
    }

    return {previewFragments, errors, addFragment, deleteFragment, fetchPreviewFragments}
}