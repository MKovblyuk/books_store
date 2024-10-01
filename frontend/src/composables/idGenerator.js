export const useIdGenerator = () => {
    const addIds = (arr) => {
        for (let i = 0; i < arr.length; i++) {
            arr[i].id = Date.now().toString() + i;
        }
    }

    return {addIds}
}