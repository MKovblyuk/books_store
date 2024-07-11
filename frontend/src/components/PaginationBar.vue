<script setup>


import { defineEmits } from 'vue'; 

const emit = defineEmits(['page_changed'])

const props = defineProps({
    meta: {
        type: Object,
        required: true
    },
});

const page_click_handler = (page) => {
    if (props.meta.current_page !== page) {
        emit('page_changed', page);
    }
}

</script>

<template>
    <nav aria-label="Page navigation example" class="d-flex justify-content-center">

        <ul class="pagination">
            <li class="page-item">
                <div @click="page_click_handler(1)" class="page-link" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </div>
            </li>



            <template v-if="meta.current_page - 1 === 0">
                <li class="page-item">
                    <div @click="page_click_handler(1)" class="page-link active">1</div>
                </li>

                <li class="page-item">
                    <div @click="page_click_handler(meta.current_page + 1)" class="page-link">{{ meta.current_page + 1}}</div>
                </li>

                <li v-if="meta.current_page + 2 <= meta.last_page" class="page-item">
                    <div @click="page_click_handler(meta.current_page + 2)" class="page-link">{{ meta.current_page + 2}}</div>
                </li>
            </template>

            <template v-else-if="meta.current_page + 1 > meta.last_page">
                <li v-if="meta.current_page - 2 > 0" class="page-item">
                    <div @click="page_click_handler(meta.current_page - 2)" class="page-link">{{ meta.current_page - 2 }}</div>
                </li>

                <li class="page-item">
                    <div @click="page_click_handler(meta.current_page - 1)" class="page-link">{{ meta.current_page -1 }}</div>
                </li>

                <li class="page-item">
                    <div @click="page_click_handler(meta.current_page)" class="page-link active">{{ meta.current_page }}</div>
                </li>
            </template>

            <template v-else>
                <li class="page-item">
                    <div @click="page_click_handler(meta.current_page - 1)" class="page-link">{{ meta.current_page - 1 }}</div>
                </li>

                <li class="page-item">
                    <div @click="page_click_handler(meta.current_page)" class="page-link active">{{ meta.current_page }}</div>
                </li>
                <li class="page-item">
                    <div @click="page_click_handler(meta.current_page + 1)" class="page-link">{{ meta.current_page + 1 }}</div>
                </li>
            </template>
    

            
            <li class="page-item">
                <div @click="page_click_handler(meta.last_page)" class="page-link" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </div>
            </li>
        </ul>
    </nav>
</template>

<style scoped>
    .page-link:hover {
        cursor: pointer;
    }
</style>