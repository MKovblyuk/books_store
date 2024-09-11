import {defineStore} from "pinia";
import {ref} from "vue";
import axios from "axios";


export const useReviewStore = defineStore('review', () => {
    const reviews = ref([]);
    const links = ref([]);
    const meta = ref([]);
    const reviewsIsLoaded = ref(false);
    const perPage = ref(2);

    async function fetchReviews(book_id, page = 1, per_page = perPage.value) {
        reviewsIsLoaded.value = false;
        const response = await axios.get(`books/${book_id}/reviews?page=${page}&per_page=${per_page}`);
        reviews.value = response.data.data;
        links.value = response.data.links;
        meta.value = response.data.meta;

        reviewsIsLoaded.value = true;
    }

    return { reviews, links, meta, reviewsIsLoaded, fetchReviews };
});