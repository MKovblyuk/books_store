export const useNumberFormatter = () => {

    function formatToString(number) {
        if (number > 1000000) {
            return Math.floor(number / 1000000) + "M";
        }

        if (number > 1000) {
            return Math.floor(number / 1000) + "K";
        }

        return number;
    }

    return {formatToString}
}