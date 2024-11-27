<script setup>

</script>

<template>
    <div class="p-2">
        <hr>
        <h5>Filtering</h5>
        <hr>

        <slot></slot>
    </div>
</template>

<style>
.section_title {
    font-weight: bold;
    margin-bottom: .4rem;
}
.filter_section {
    margin-bottom: 10px;
}

.list-group{
    max-height: 300px;
    margin-bottom: 10px;
    overflow-x: hidden;
}

.list-group-item{
    border-bottom: none;
    padding: .125rem;
}

</style>