<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    title: String,
    cancelBtnText: String,
    okBtnText: String,
    okBtnCloseModal: {
        type: Boolean,
        default: true,
    }
});

const emit = defineEmits(['okBtnClicked', 'modalHidden']);
const modalRef = ref();

onMounted(() => {
    modalRef.value.addEventListener('hidden.bs.modal', () => emit('modalHidden'));
})

</script>

<template>
    <div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="modalRef">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <slot></slot>
            </div>
            <div class="modal-footer">
                <button 
                    type="button" 
                    class="btn btn-secondary" 
                    data-bs-dismiss="modal"
                >
                    {{cancelBtnText ?? 'Cancel'}}
                </button>
                <button 
                    type="button" 
                    class="btn btn-primary" 
                    @click="emit('okBtnClicked')" 
                    :data-bs-dismiss="okBtnCloseModal ? 'modal' : ''"
                >
                    {{ okBtnText ?? 'OK'}}
                </button>
            </div>
            </div>
        </div>
    </div>  
</template>