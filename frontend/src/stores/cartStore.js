import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useCartStore = defineStore('cart', () => {
    const items = ref([]);

    const totalPrice = computed({
        get: () => {
            let totalPrice = 0;

            items.value.forEach(item => {
                totalPrice += Number(item.getPriceWithDiscount());
            });
    
            return totalPrice.toFixed(2);
        }
    });

    function addItem(cartItem) 
    {
        if (items.value.findIndex( item => item.compare(cartItem)) < 0) {
            items.value.push(cartItem);
        }
    }

    function removeItem(cartItem) 
    {   
        const index = items.value.findIndex( item => item.bookId === cartItem.bookId);
        items.value.splice(index, 1);
    }

    function $reset() 
    {
        items.value = [];
    }

    return {items, addItem, removeItem, totalPrice, $reset};
});