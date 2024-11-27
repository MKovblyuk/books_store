import { useRangeGenerator } from "./rangeGenerator";

export const useStatisticFormatter = (year) => {
    
    /**
     * 
     * @returns Month array of months numbers for selected year
     */
    function getMonthsNumbers() {
        return year === (new Date()).getFullYear()
            ? useRangeGenerator().generate(1, (new Date()).getMonth() + 1)
            : useRangeGenerator().generate(1, 12);
    }
    
    /**
     * 
     * @param generalData 
     * @param filterCallback Callback for filtering each data item
     * @returns Filtered generalData data items 
     */
    function getData(generalData, filterCallback) {
        const data = [];
        const months = getMonthsNumbers();
        
        for (let i = 0; i < months.length; i++) {
            const item = generalData?.months?.filter(m => m.month === months[i])[0];
            data[i] = item ? filterCallback(item.data) : 0;
        }
    
        return data;
    }

    return {getMonthsNumbers, getData}
}