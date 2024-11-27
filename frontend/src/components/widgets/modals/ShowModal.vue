<script setup>
import { ref } from 'vue';

const modal = ref(null);
defineExpose({modal});

</script>

<template>
    <div 
        class="modal"
        tabindex="-1" 
        ref="modal"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body audio-body">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div> 
</template>