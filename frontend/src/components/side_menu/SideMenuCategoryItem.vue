<script setup>

import CategoriesList from "@/components/categories/CategoriesList.vue";
import { useCategoryStore } from "@/stores/categoryStore";
import { onMounted, ref } from "vue";

const categoryStore = useCategoryStore();
const closeBtn = ref(null);

onMounted(() => {
    categoryStore.fetchCategories();
});

</script>

<template>
    <div>
        <button class="btn btn-primary w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            Categories
        </button>

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Categories</h5>
                <button 
                    type="button" 
                    class="btn-close text-reset" 
                    data-bs-dismiss="offcanvas" 
                    aria-label="Close"
                    id="offcanvas-close-btn"
                    ref="closeBtn"
                ></button>
            </div>
            <div class="offcanvas-body">
                <CategoriesList 
                    :categories="categoryStore.categories"
                    @category_selected="closeBtn.click()"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>