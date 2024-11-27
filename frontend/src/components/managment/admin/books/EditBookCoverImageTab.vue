<script setup>
import UIImageInput from '@/components/ui/form_components/UIImageInput.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const props = defineProps(['bookId']);
const emit = defineEmits(['coverImageUpdated']);

const currentCoverImageUrl = ref();
const newCoverImage = ref();
const errors = ref();

async function fetchCoverImage() {
    const response = await axios.get('books', {
        params: {
            'fields[books]': 'cover_image_path',
            'filter[id]': props.bookId
        }
    })

    currentCoverImageUrl.value = response.data.data?.[0].coverImageUrl;
}

// change post method on patch

async function uploadNewCoverImage() {
    try {
        errors.value = null;
        const response = await axios.post('books/' + props.bookId +'/uploadCoverImage', {
            'image': newCoverImage.value
        }, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })

        if (response.status === 201) {
            alert('Image uploaded');
            emit('coverImageUpdated');
            fetchCoverImage();
        }
    } catch(e) {
        if (e.response.status === 422) {
            errors.value = e.response.data?.errors?.image[0]
        }
    }
}

onMounted(() => {
    fetchCoverImage();
});

</script>

<template>
    <div class="pt-3">
        <div v-if="currentCoverImageUrl">
            <div>Current image</div>
            <img 
                :src="currentCoverImageUrl" 
                alt="current_cover_image"
                width="200px"
                height="200px"
                class="mt-1"
            />
        </div>
        <div v-else>Image Not Found</div>

        <UIImageInput
            labelTitle="Select new cover image"
            class="mb-3 mt-3"
            @change="e => newCoverImage = e.target.files[0]"
            inputId="coverImageInput"
            :errorMessage="errors"
        />
        <button class="btn btn-primary" @click="uploadNewCoverImage">
            Update
        </button>
    </div>
</template>