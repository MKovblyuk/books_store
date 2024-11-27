<script setup>
import { ref } from 'vue';

const emit = defineEmits(['sorting_order_chaged']);

const props = defineProps(['isActive']);
const ascending = ref(true);

function chageSortOrder() {
    ascending.value = !ascending.value;
    emit('sorting_order_chaged', ascending.value);
}

</script>

<template>
    <div 
        class="column_header"
        @click="chageSortOrder"
    >
        <div>
            <slot></slot>
        </div>
        <div>
            <span v-show="isActive && ascending">&uArr;</span>
            <span v-show="isActive && !ascending">&dArr;</span>
        </div>
    </div>
</template>

<style scoped>

.column_header {
    display: flex;
}
.column_header:hover {
    cursor: pointer;
}

</style>