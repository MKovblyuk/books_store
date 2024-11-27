<script setup>
import { ref } from 'vue';

const props = defineProps(['show', 'btnClass', 'btnText', 'selectedBtnText']);
const emit = defineEmits(['click']);

const show = ref(props.show ?? false);

function handleClick(e) {
    show.value = !show.value;
    emit('click', e);
}
</script>

<template>
    <div>
        <button name="clickable" @click="handleClick" :class="btnClass ?? 'btn btn-primary'">
            {{ show ? selectedBtnText ?? 'Hide' : btnText ?? 'Show'}}
            {{ show ? 	'&uArr;' : '&dArr;'  }}
        </button>
        <div v-show="show">
            <slot></slot>
        </div>
    </div>
</template>