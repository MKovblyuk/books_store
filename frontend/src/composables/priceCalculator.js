export const usePriceCalculator = () => {
    const calculate = (price, discount) => (price - (price * discount / 100)).toFixed(2);

    return {calculate}
} 