import {BookFormats} from "@/enums/bookFormats.js";


export function useBook(book) {
    function getAvailableFormat() {
        if (book.paperFormat) {
            return BookFormats.Paper;
        } else if (book.electronicFormat) {
            return BookFormats.Electronic;
        } else if (book.audioFormat) {
            return BookFormats.Audio;
        }
    }

    function getFormatData(formatName) {
        if (formatName === BookFormats.Audio) {
            return book.audioFormat;
        } else if (formatName === BookFormats.Electronic) {
            return book.electronicFormat;
        } else if (formatName === BookFormats.Paper) {
            return book.paperFormat;
        } else {
            throw new Error('Incorrect Format');
        }
    }

    return { getAvailableFormat, getFormatData }
}