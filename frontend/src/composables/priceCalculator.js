export const usePriceCalculator = () => {
    const calculate = (price, discount) => (price - (price * discount / 100));
    const calculateToFixed = (price, discount, fractionDigits = 2) => calculate(price, discount).toFixed(fractionDigits);

    return {calculate, calculateToFixed}
} 