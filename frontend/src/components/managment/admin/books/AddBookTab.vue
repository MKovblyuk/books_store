<script setup>
import AuthorSelect from '@/components/authors/AuthorSelect.vue';
import CategorySelect from '@/components/categories/CategorySelect.vue';
import PublisherSelect from '@/components/publishers/PublisherSelect.vue';
import UIFileInput from '@/components/ui/form_components/UIFileInput.vue';
import UIImageInput from '@/components/ui/form_components/UIImageInput.vue';
import UIInput from '@/components/ui/form_components/UIInput.vue';
import UITextArea from '@/components/ui/form_components/UITextArea.vue';
import UIErrorsList from '@/components/ui/sections/UIErrorsList.vue';
import CheckToggleSection from '@/components/widgets/CheckToggleSection.vue';
import axios from 'axios';
import { ref } from 'vue';

const emit = defineEmits(['bookCreated', 'tryReturn']);

const errors = ref();
const newBookData = ref({});
const coverImage = ref();
const audioFiles = ref();
const electronicFiles = ref();
const audioFormat = ref({
    price: '',
    discount: '',
    duration: ''
});
const electronicFormat = ref({
    price: '',
    discount: '',
    pageCount: ''
});
const paperFormat = ref({
    price: '',
    discount: '',
    pageCount: '',
    quantity: ''
});
let audioChecked = false;
let electronicChecked = false;
let paperChecked = false;


async function createBook() {
    try {
        const data = {...newBookData.value, formats: {}};

        if (audioChecked) {
            data.formats.audio = audioFormat.value;
        }
        if (electronicChecked) {
            data.formats.electronic = electronicFormat.value;   
        }
        if (paperChecked) {
            data.formats.paper = paperFormat.value;
        }

        const formData = {
            'data': JSON.stringify(data),
            'audioFiles[]': audioFiles.value,
            'electronicFiles[]': electronicFiles.value,
        }

        const response = await axios.post('books', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        if (response.status === 201) {
            alert('Book created');
            emit('bookCreated');
        }
    } catch(e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
}

</script>

<template>
    <div>
        <div>
            <button class="btn btn-success" @click="emit('tryReturn')">
                &lArr;
            </button>
        </div>
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
            <UIImageInput 
                labelTitle="Cover image"
                class="mb-5"
                @change="e => coverImage = e.target.files[0]"
                inputId="coverImageInput"
            />

            <UIErrorsList 
                :errors="errors?.formats" 
            />
            <UIErrorsList
                :errors="errors?.['formats.audio']"
            />
            <CheckToggleSection
                title="Audio Format"
                inputId="checkAudio"
                @change="e => audioChecked = e.target.checked"
                slotClass="mt-2 ps-4"
            >
                <div class="d-flex">
                    <UIInput 
                        v-model="audioFormat.price"
                        labelTitle="Price"
                        class="mb-3"
                        inputId="audioPrice"
                        type="number"
                    />
                    <UIInput 
                        v-model="audioFormat.discount"
                        labelTitle="Discount"
                        class="mb-3 mx-2"
                        inputId="audioDiscount"
                        type="number"
                    />
                    <UIInput 
                        v-model="audioFormat.duration"
                        labelTitle="Duration"
                        class="mb-3"
                        inputId="audioDuration"
                        type="number"
                    />
                </div>
                <UIFileInput 
                    labelTitle="Audio Files"
                    class="mb-3"
                    @change="e => audioFiles = e.target.files"
                    inputId="audioFilesInput"
                    :multiple="true"
                />
            </CheckToggleSection>

            <UIErrorsList
                :errors="errors?.['formats.electronic']"
            />
            <CheckToggleSection
                title="Electronic Format"
                inputId="checkElectronic"
                @change="e => electronicChecked = e.target.checked"
                slotClass="mt-2 ps-4"
            >
                <div class="d-flex">
                    <UIInput 
                        v-model="electronicFormat.price"
                        labelTitle="Price"
                        class="mb-3"
                        inputId="electronicPrice"
                        type="number"
                    />
                    <UIInput 
                        v-model="electronicFormat.discount"
                        labelTitle="Discount"
                        class="mb-3 mx-2"
                        inputId="electronicDiscount"
                        type="number"
                    />
                    <UIInput 
                        v-model="electronicFormat.pageCount"
                        labelTitle="Page Count"
                        class="mb-3"
                        inputId="elPageCount"
                        type="number"
                    />
                </div>
                <UIFileInput 
                    labelTitle="Electronic Files"
                    class="mb-3"
                    @change="e => electronicFiles = e.target.files"
                    inputId="elFilesInput"
                    :multiple="true"
                />
            </CheckToggleSection>

            <UIErrorsList
                :errors="errors?.['formats.paper']"
            />
            <CheckToggleSection
                title="Paper Format"
                inputId="checkPaper"
                @change="e => paperChecked = e.target.checked"
                slotClass="mt-2 ps-4"
            >
                <div class="d-flex">
                    <UIInput 
                        v-model="paperFormat.price"
                        labelTitle="Price"
                        class="mb-3"
                        inputId="paperPrice"
                        type="number"
                    />
                    <UIInput 
                        v-model="paperFormat.discount"
                        labelTitle="Discount"
                        class="mb-3 mx-2"
                        inputId="paperDiscount"
                        type="number"
                    />
                    <UIInput 
                        v-model="paperFormat.pageCount"
                        labelTitle="Page Count"
                        class="mb-3"
                        inputId="paperPageCount"
                        type="number"
                    />
                    <UIInput 
                        v-model="paperFormat.quantity"
                        labelTitle="Quantity"
                        class="mb-3 ms-2"
                        inputId="paperQuantity"
                        type="number"
                    />
                </div>
            </CheckToggleSection>
        </div>
        <div class="p-1 mt-5">
            <button class="btn btn-primary me-1" @click="emit('tryReturn')">Cancel</button>
            <button class="btn btn-primary" @click="createBook">Create</button>
        </div>
    </div>
</template>