<script setup>
import { ref } from 'vue';

const iconPath = ref('/src/assets/icons/rating-star.svg');
const selectedIconPath = ref('/src/assets/icons/rating-star-yellow.svg')

const rating = defineModel();

</script>

<template>
    <div>
        Rating: 
        <span class="star-rating">
            <template>

            </template>
            <label for="rate-1"> 
                <img :src="rating >= 1 ? selectedIconPath : iconPath">
            </label>
            <input type="radio" name="rating" id="rate-1" value="1" v-model="rating">
            <label for="rate-2">
                <img :src="rating >= 2 ? selectedIconPath : iconPath">
            </label>
            <input type="radio" name="rating" id="rate-2" value="2" v-model="rating">
            <label for="rate-3">
                <img :src="rating >= 3 ? selectedIconPath : iconPath">
            </label>
            <input type="radio" name="rating" id="rate-3" value="3" v-model="rating">
            <label for="rate-4">
                <img :src="rating >= 4 ? selectedIconPath : iconPath">
            </label>
            <input type="radio" name="rating" id="rate-4" value="4" v-model="rating">
            <label for="rate-5">
                <img :src="rating >= 5 ? selectedIconPath : iconPath">
            </label>
            <input type="radio" name="rating" id="rate-5" value="5" v-model="rating">
	    </span>
    </div>
</template>

<style scoped>

.star-rating {
	white-space: nowrap;
}
.star-rating [type="radio"] {
	appearance: none;
}
.star-rating img {
	height: 1.4rem;
    width: 1.4rem;
}

.star-rating label:is(:hover, :has(~ :hover)) img {
	transform: scale(1.35);
}

</style>