<script setup>
const props = defineProps(['newPrice', 'oldPrice', 'formatName']);
</script>

<template>
    <div class="book_card_format_item">
        <div>
            <div class="text-decoration-line-through">
                {{ oldPrice }}
            </div>
            <div>
                {{ newPrice }}
            </div>
        </div>
        <div>
            {{ formatName }}
        </div>
    </div>
</template>

<style scoped>

.book_card_format_item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px rgb(182, 182, 182) solid;
    border-radius: 0.3rem;
    padding: 0.15rem 0.7rem;
}

</style>