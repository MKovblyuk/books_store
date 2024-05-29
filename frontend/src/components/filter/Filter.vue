<script setup>
import {ref} from "vue";

const publishers = ref([
    {
        "id": 1,
        "name": "Kuhn-McDermott"
    },
    {
        "id": 2,
        "name": "Klocko, Gerhold and Mueller"
    },
    {
        "id": 3,
        "name": "Herzog-Heathcote"
    },
    {
        "id": 4,
        "name": "Hirthe-Hand"
    },
    {
        "id": 5,
        "name": "Heidenreich Group"
    },
    {
        "id": 6,
        "name": "Hill LLC"
    },
    {
        "id": 7,
        "name": "Considine-Pagac"
    },
    {
        "id": 8,
        "name": "Beatty-Boehm"
    },
    {
        "id": 9,
        "name": "Brakus-O'Conner"
    },
    {
        "id": 10,
        "name": "Mitchell PLC"
    }
]);

const authors = ref([
    {
        "id": 10,
        "firstName": "Jorge",
        "lastName": "Lebsack",
        "description": "Voluptatem eaque dolorem asperiores est vel id voluptatem. Omnis quia enim nobis et ipsa velit. Non voluptates sunt vel id aspernatur blanditiis voluptates.",
        "photoUrl": "https://via.placeholder.com/640x480.png/004422?text=libero"
    },
    {
        "id": 9,
        "firstName": "Ruby",
        "lastName": "Lynch",
        "description": "Inventore maxime maxime doloremque beatae laborum aut. Optio qui harum est excepturi debitis. Esse ducimus ea et minus quas quas modi. Deleniti aut maxime assumenda ex quia minus.",
        "photoUrl": "https://via.placeholder.com/640x480.png/0000ff?text=adipisci"
    },
    {
        "id": 8,
        "firstName": "Frederique",
        "lastName": "Wolff",
        "description": "At optio est molestiae sint dolor dignissimos architecto. Voluptate sapiente et reprehenderit molestias pariatur consequatur.",
        "photoUrl": null
    },
    {
        "id": 7,
        "firstName": "Retha",
        "lastName": "Mante",
        "description": "Ipsum soluta occaecati ea minima pariatur a ipsum. Dignissimos natus necessitatibus et. Veritatis ab magni temporibus adipisci dignissimos explicabo et.",
        "photoUrl": "https://via.placeholder.com/640x480.png/005511?text=perferendis"
    },
    {
        "id": 6,
        "firstName": "Evie",
        "lastName": "Glover",
        "description": "Rerum vel enim beatae consectetur repellendus. Tempore eius dolores saepe. Qui minima officiis quod et ea et temporibus expedita.",
        "photoUrl": "https://via.placeholder.com/640x480.png/00bbee?text=eligendi"
    },
    {
        "id": 5,
        "firstName": "Arnulfo",
        "lastName": "Schuster",
        "description": "Possimus sunt accusantium deleniti non occaecati veniam labore quis. Odit fugit quis dignissimos velit autem. Omnis recusandae et cupiditate quaerat delectus voluptatibus.",
        "photoUrl": null
    },
    {
        "id": 4,
        "firstName": "Elda",
        "lastName": "Lemke",
        "description": "Nihil mollitia ab architecto qui facere perferendis et. Hic dolores maxime iure id quas. Ut unde voluptatum corporis odio sit et perspiciatis.",
        "photoUrl": "https://via.placeholder.com/640x480.png/0099bb?text=beatae"
    },
    {
        "id": 3,
        "firstName": "Forrest",
        "lastName": "Kunze",
        "description": "Dolore voluptate eaque qui ut non veritatis quas dignissimos. Repellat enim suscipit sit reiciendis autem ullam quasi. Sed reiciendis quae quod mollitia modi recusandae.",
        "photoUrl": null
    },
    {
        "id": 2,
        "firstName": "Sasha",
        "lastName": "Johnston",
        "description": "Rem consequuntur voluptatem voluptas vel consequatur. Beatae ea quo ut labore. Id non rem consectetur corrupti. Animi debitis cumque ex voluptate illum.",
        "photoUrl": null
    },
    {
        "id": 1,
        "firstName": "Sigurd",
        "lastName": "Auer",
        "description": "Quia quis illo enim non quasi. Minima eos officia commodi et error velit et alias. Aut cumque aut aut error. Velit magni necessitatibus praesentium deleniti velit.",
        "photoUrl": null
    }
]);

const languages = ref([
    'German',
    'English',
    'Ukrainian',
    'French'
]);

</script>

<template>
    <div class="p-2">
        <hr>
        <h5>Filtering</h5>
        <hr>

        <section class="filter_section">
            <div class="section_title">
                Book Type
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="form_check_paper">
                        <label class="form-check-label" for="form_check_paper">
                            Paper
                        </label>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="form_check_electronic">
                        <label class="form-check-label" for="form_check_electronic">
                            Electronic
                        </label>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="form_check_audio">
                        <label class="form-check-label" for="form_check_audio">
                            Audio
                        </label>
                    </div>
                </li>
            </ul>
        </section>

        <section class="filter_section">
            <div class="section_title">
                Publishers
            </div>
            <ul class="list-group list-group-flush">
                <li v-for="publisher in publishers" :key="publisher.id" class="list-group-item">
                    <div  class="form-check">
                        <input class="form-check-input" type="checkbox" :id="`form_check_publisher_${publisher.id}`">
                        <label class="form-check-label" :for="`form_check_publisher_${publisher.id}`">
                            {{publisher.name}}
                        </label>
                    </div>
                </li>
            </ul>
        </section>

        <section class="filter_section">
            <div class="section_title">
                Authors
            </div>
            <ul class="list-group list-group-flush">
                <li v-for="author in authors" :key="author.id" class="list-group-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" :id="`form_check_author_${author.id}`">
                        <label class="form-check-label" :for="`form_check_author_${author.id}`">
                            {{author.firstName + " " + author.lastName}}
                        </label>
                    </div>
                </li>
            </ul>
        </section>

        <section class="filter_section">
            <div class="section_title">
                Language
            </div>
            <ul class="list-group list-group-flush">
                <li v-for="i in languages.length" class="list-group-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" :id="`form_check_language_${languages[i-1]}`">
                        <label class="form-check-label" :for="`form_check_language_${languages[i-1]}`">
                            {{languages[i-1]}}
                        </label>
                    </div>
                </li>
            </ul>
        </section>

        <section class="filter_section">
            <div class="section_title">
                Price
            </div>
            <div>
                <label>From</label>
                <input class="w-100 mb-2" type="number" placeholder="From">

                <label>To</label>
                <input class="w-100 mb-4" type="number" placeholder="To">

                <button class="btn btn-primary w-100">Apply</button>
            </div>
        </section>
    </div>
</template>

<style scoped>
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