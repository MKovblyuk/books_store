import MimeTypeExtensions from "@/helpers/MimeTypeExtensions";
import axios from "axios";
import { ref } from "vue";

export const useElectronicBook = () => {
    const openLinkRef = ref(null);
    const downloadLinkRef = ref(null);
    
    async function openBook(bookId, extension) {
        try {
            const response = await axios.get(`/books/electronic/${bookId}/download/${extension}`, { 
                responseType: 'arraybuffer',
            });
    
            const blob = new Blob([response.data], { type: MimeTypeExtensions.getMimeType(extension) });
            openLinkRef.value.href = window.URL.createObjectURL(blob);
            openLinkRef.value.target="_blank";
            openLinkRef.value.click();
            window.URL.revokeObjectURL(openLinkRef.value.href);
        } catch (error) {
            console.error('Error opening file:', error);
        }
    }

    async function downloadBook(bookId, extension, downloadName) {
        try {
            const response = await axios.get(`/books/electronic/${bookId}/download/${extension}`, { 
                responseType: 'arraybuffer',
            });
    
            const blob = new Blob([response.data], { type: MimeTypeExtensions.getMimeType(extension) });
            downloadLinkRef.value.href = window.URL.createObjectURL(blob);
            downloadLinkRef.value.download = downloadName;
            downloadLinkRef.value.click();
            window.URL.revokeObjectURL(downloadLinkRef.value.href);
        } catch (error) {
            console.error('Error downloading file:', error);
        }
    }

    return {
        openLinkRef, downloadLinkRef, openBook, downloadBook
    }
}