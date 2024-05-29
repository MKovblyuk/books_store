<script setup>

</script>

<template>
    <div class="card" style="width: 14rem;">
        <img src="https://img.freepik.com/free-photo/painting-mountain-lake-with-mountain-background_188544-9126.jpg" class="card-img-top" alt="...">
        <div class="p-3">
            <div>
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <div class="">
                    <p>Price: <span>34 456</span></p>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-danger card-btn">To Cart</button>
                <button class="btn btn-success card-btn">Buy</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.card {
    font-size: 14px;
}

.card-btn {
    width: 48%;
}
.card:hover{
    cursor: pointer;
}

.card-img-top{
    height: 200px;
}

</style>