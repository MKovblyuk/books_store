/**
 * Generate random color or color from available colors list
 */
export class ColorGenerator {
    #availableRGBColors = [
        [255, 102, 102],
        [76, 153, 0],
        [0, 0, 255],
        [153, 0, 153],
        [102, 102, 0],
        [0, 255, 0],
        [255, 0, 0],
        [255, 255, 0],
        [102, 255, 102],
        [102, 255, 255],
        [0, 153, 153],
        [204, 102, 0],
        [255, 51, 255],
        [153, 0, 0],
        [102, 102, 0],
        [255, 178, 102],
        [0, 255, 128],
        [255, 255, 102],
    ];

    #availableColorIndex = 0;

    constructor(availableRGBColors = []) {
        if (availableRGBColors.length > 0) {
            this.#availableRGBColors = availableRGBColors;
        }
    }

    generateRandomRgbArray() {
        return [
            Math.floor(Math.random() * 256),
            Math.floor(Math.random() * 256),
            Math.floor(Math.random() * 256)
        ]
    }

    generateRandomRgbString() {
        const [r,g,b] = this.generateRandomRgbArray();
        return `rgb(${r}, ${g}, ${b})`; 
    }

    getAvailableRgbArray() {
        if (this.#availableColorIndex >= this.#availableRGBColors.length) {
            this.#availableColorIndex = 0;
        }

        return this.#availableRGBColors[this.#availableColorIndex++];
    }

    getAvailableRgbString() {
        const [r,g,b] = this.getAvailableRgbArray();
        return `rgb(${r}, ${g}, ${b})`; 
    }
}