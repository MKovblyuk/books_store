export const useRangeGenerator = () => {
    const generate = (start, end) => {
        const result = [start];

        while (start < end) {
            result.push(++start);
        }

        return result;
    }

    return {generate};
}