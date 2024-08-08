
const types = {
    'pdf': 'application/pdf',
    'txt': 'text/plain',
    'mp3': 'audio/mpeg',
};

export default {
    getMimeType: (extension) => {
        return types[extension];
    }
}