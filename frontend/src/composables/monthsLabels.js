import { computed } from "vue";
import { useStatisticFormatter } from "./statisticFormatter";

export const useMonthsLabels = (selectedYear) => {
    const labels = computed(() => {
        if (!selectedYear.value) return [];

        return useStatisticFormatter(selectedYear.value)
            .getMonthsNumbers(selectedYear.value)
            .map(item => item + '/' + selectedYear.value);
    })

    return { labels };
}