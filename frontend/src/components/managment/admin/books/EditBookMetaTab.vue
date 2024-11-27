<script setup>
import AuthorSelect from '@/components/authors/AuthorSelect.vue';
import CategorySelect from '@/components/categories/CategorySelect.vue';
import PublisherSelect from '@/components/publishers/PublisherSelect.vue';
import UIInput from '@/components/ui/form_components/UIInput.vue';
import UITextArea from '@/components/ui/form_components/UITextArea.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const props = defineProps(['bookId']);
const emit = defineEmits(['bookUpdated', 'tryReturn']);

const errors = ref();
const newBookData = ref({});

async function fetchBook() {
    const response = await axios.get('books/' + props.bookId);
    newBookData.value = response.data.data;
}

async function updateBook() {
    try {
        const response = await axios.patch('books/' + props.bookId, newBookData.value);

        if (response.status === 200) {
            alert('Book updated');
            emit('bookUpdated');
        }
    } catch(e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
}

onMounted(() => {
    fetchBook();
})

</script>

<template>
    <div>
        <UIInput
            v-model="newBookData.name"
            labelTitle="Name"
            class="mb-3"
            inputId="nameInput"
            :errorMessage="errors?.name?.[0]"
        />
        <UITextArea 
            v-model="newBookData.description"
            labelTitle="Description"
            class="mb-3"
            textAreaId="descriptionTextArea"
            :errorMessage="errors?.description?.[0]"
        />
        <UIInput
            v-model="newBookData.publicationYear"
            labelTitle="Publication year"
            class="mb-3"
            inputId="publicationYearInput"
            :errorMessage="errors?.publication_year?.[0]"
        />
        <UIInput
            v-model="newBookData.language"
            labelTitle="Language"
            class="mb-3"
            inputId="languageInput"
            :errorMessage="errors?.language?.[0]"
        />
        <CategorySelect
            v-model="newBookData.categoryId"
            class="mb-3"
            :errorMessage="errors?.category_id?.[0]"
        />
        <PublisherSelect 
            v-model="newBookData.publisherId"
            class="mb-3"
            :errorMessage="errors?.publisher_id?.[0]"
        />
        <AuthorSelect 
            v-model="newBookData.authorsIds"
            class="mb-3"
            :errorMessage="errors?.authors_ids?.[0]"
            :multiple="true"
        />

        <div class="md-2 text-danger">
            <div v-for="error in errors?.formats">
                {{ error }}
            </div>
        </div>

        <div class="p-1 mt-5">
            <button class="btn btn-primary me-1" @click="emit('tryReturn')">Cancel</button>
            <button class="btn btn-primary" @click="updateBook">Update</button>
        </div>
    </div>
</template>