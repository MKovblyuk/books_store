import MimeTypeExtensions from "@/helpers/MimeTypeExtensions";
import axios from "axios";
import { ref } from "vue";

export const useAudioBook = () => {
    const audioSrc = ref('');
    const downloadLinkRef = ref(null);

    async function downloadBook(bookId, extension, downloadName) {
        try {
            const response = await axios.get(`books/audio/${bookId}/download/${extension}`, { 
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

    async function openBook(bookId, extension) {
        try {
            const response = await axios.get(`books/audio/${bookId}/download/${extension}`, { 
                responseType: 'arraybuffer',
            });
    
            const blob = new Blob([response.data], { type: MimeTypeExtensions.getMimeType(extension) });
            audioSrc.value = window.URL.createObjectURL(blob);
        } catch (error) {
            console.error('Error reading file:', error);
        }
    }

    return {downloadLinkRef, audioSrc, downloadBook, openBook}
}