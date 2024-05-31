<script setup>
import {ref} from "vue";
const categories = ref([
    {
        "id": 2,
        "name": "science and technology",
        "parentId": 1,
        "children": [
            {
                "id": 3,
                "name": "astronomy, space",
                "parentId": 2,
                "children": [
                    {
                        "id": 4,
                        "name": "theoretical astronomy",
                        "parentId": 3,
                        "children": []
                    },
                    {
                        "id": 5,
                        "name": "stellar astronomy",
                        "parentId": 3,
                        "children": []
                    },
                    {
                        "id": 6,
                        "name": "celestial mechanics",
                        "parentId": 3,
                        "children": []
                    }
                ]
            },
            {
                "id": 7,
                "name": "biological sciences",
                "parentId": 2,
                "children": [
                    {
                        "id": 8,
                        "name": "general genetics",
                        "parentId": 7,
                        "children": []
                    },
                    {
                        "id": 9,
                        "name": "microbiology. virology",
                        "parentId": 7,
                        "children": []
                    }
                ]
            },
            {
                "id": 10,
                "name": "chemistry",
                "parentId": 2,
                "children": [
                    {
                        "id": 11,
                        "name": "inorganic chemistry",
                        "parentId": 10,
                        "children": []
                    },
                    {
                        "id": 12,
                        "name": "organic chemistry",
                        "parentId": 10,
                        "children": []
                    }
                ]
            }
        ]
    },
    {
        "id": 13,
        "name": "history",
        "parentId": 1,
        "children": [
            {
                "id": 14,
                "name": "military history",
                "parentId": 13,
                "children": []
            },
            {
                "id": 15,
                "name": "world history",
                "parentId": 13,
                "children": []
            }
        ]
    },
    {
        "id": 13,
        "name": "test category",
        "parentId": 1,
        "children": []
    }
]);

</script>

<template>
    <div v-for="category in categories" :key="category.id" class="mb-2">
        <div v-if="category.children.length !== 0" class="btn-group w-100">
            <button type="button" class="btn btn-secondary dropdown-toggle w-100" data-bs-toggle="dropdown" aria-expanded="false">
                {{category.name}}
            </button>
            <ul class="dropdown-menu w-75">
                <li>
                    <button class="dropdown-item" type="button">
                        All
                    </button>
                </li>
                <li v-for="subcategory in category.children" :key="subcategory.id">
                    <button class="dropdown-item" type="button">
                        {{subcategory.name}}
                    </button>
                </li>
            </ul>
        </div>
        <div v-else>
            <button class="btn btn-secondary w-100">
                {{category.name}}
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>