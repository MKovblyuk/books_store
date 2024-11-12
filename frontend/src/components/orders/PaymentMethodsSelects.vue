<script setup>
import { BookFormats } from '@/enums/bookFormats';
import { useCartStore } from '@/stores/cartStore';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const emit = defineEmits(['payment_method_id_changed']);

const paymentMethods = ref([]);
const cartStore = useCartStore();

onMounted(() => {
    fetchPaymentMethods();
});

async function fetchPaymentMethods()
{
    const response = await axios.get('/paymentMethods');
    paymentMethods.value = response.data.data;
}

function paymentMethodIsAllowed(method) 
{
    return method.name === 'Upon Receiving' 
        ? cartStore.items.every(item => item.bookFormat === BookFormats.Paper) 
        : true;
}

</script>

<template>
    <div>
        <template v-for="method in paymentMethods" :key="method.id">
            <template v-if="paymentMethodIsAllowed(method)">                                
                <input 
                    type="radio" 
                    :id="'payment_method_' + method.id" 
                    name="payment_method" 
                    :value="method.id"
                    @change="e => emit('payment_method_id_changed', e.target.value)"
                    class="me-2"
                >
                <label :for="'payment_method_' + method.id">{{method.method}}</label><br>
            </template>
        </template>
    </div>
</template>