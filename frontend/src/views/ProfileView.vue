<script setup>
import UsersBookList from "@/components/user/BookList.vue";
import BookList from "@/components/books/BookList.vue";
import OrderList from "@/components/orders/OrderList.vue"
import {ref} from "vue";
import axios from "axios";

const user = ref({
    "id": 13,
    "firstName": "TomCustomer",
    "lastName": "TomLast",
    "email": "customer@email.com",
    "role": "Customer",
    "phoneNumber": "232112"
});

const passwordData = ref({
    "currentPassword": "",
    "newPassword": "",
    "newPasswordConfirmation": "",
});

const books = [
{
            "id": 1,
            "name": "Nihil ut et sequi dicta.",
            "description": "Velit eum facilis expedita quia. Consequatur autem quis quo et. Rerum non ex corrupti repellat quia aut.",
            "publicationYear": "2018",
            "language": "German",
            "coverImageUrl": "https://via.placeholder.com/640x480.png/00ccdd?text=libero",
            "publishedAt": "2000-06-02 13:45:46",
            "audioFormat": null,
            "electronicFormat": null,
            "paperFormat": {
                "id": 1,
                "price": "320.87",
                "discount": "1.12",
                "quantity": 100,
                "pageCount": 187
            },
            "publisherId": 1,
            "categoryId": 13
        },
        {
            "id": 2,
            "name": "Neque sunt nam qui sunt.",
            "description": "Quos quod id quae tenetur. Dignissimos distinctio optio unde vel. Neque quas libero nemo est. Inventore ullam est enim. Quisquam et culpa aut quae itaque quia.",
            "publicationYear": "1981",
            "language": "English",
            "coverImageUrl": "https://via.placeholder.com/640x480.png/00aa99?text=aut",
            "publishedAt": null,
            "audioFormat": null,
            "electronicFormat": null,
            "paperFormat": {
                "id": 2,
                "price": "386.12",
                "discount": "4.82",
                "quantity": 37,
                "pageCount": 1172
            },
            "publisherId": 2,
            "categoryId": 5
        },
        {
            "id": 3,
            "name": "Ea corrupti et et non.",
            "description": "Iusto et quia qui et. Magni voluptas omnis ex vero molestias accusamus corporis.",
            "publicationYear": "2004",
            "language": "German",
            "coverImageUrl": null,
            "publishedAt": "1976-02-02 08:04:31",
            "audioFormat": null,
            "electronicFormat": {
                "id": 1,
                "price": "173.27",
                "discount": "7.00",
                "pageCount": 1134
            },
            "paperFormat": {
                "id": 3,
                "price": "359.66",
                "discount": "2.54",
                "quantity": 113,
                "pageCount": 276
            },
            "publisherId": 3,
            "categoryId": 6
        },
        {
            "id": 4,
            "name": "Ut porro qui totam.",
            "description": "Iure quia facilis et totam id. Doloremque voluptate et quo natus quia repellendus. Sint eligendi nostrum accusamus sunt corporis.",
            "publicationYear": "1999",
            "language": "English",
            "coverImageUrl": "https://via.placeholder.com/640x480.png/005577?text=et",
            "publishedAt": "1976-10-08 07:41:15",
            "audioFormat": null,
            "electronicFormat": {
                "id": 2,
                "price": "359.06",
                "discount": "6.34",
                "pageCount": 884
            },
            "paperFormat": {
                "id": 4,
                "price": "302.74",
                "discount": "6.25",
                "quantity": 1,
                "pageCount": 792
            },
            "publisherId": 9,
            "categoryId": 3
        },
        {
            "id": 5,
            "name": "Modi fuga omnis qui.",
            "description": "Expedita at non quis iure omnis atque. Natus blanditiis et aperiam nihil at sequi quo. Dignissimos qui accusantium nihil ab minus quo eum. Ut exercitationem ea sed quis.",
            "publicationYear": "2005",
            "language": "French",
            "coverImageUrl": "https://via.placeholder.com/640x480.png/00aa22?text=et",
            "publishedAt": "2005-10-28 22:06:40",
            "audioFormat": {
                "id": 1,
                "price": "453.01",
                "discount": "9.57",
                "duration": 881
            },
            "electronicFormat": {
                "id": 3,
                "price": "442.68",
                "discount": "5.16",
                "pageCount": 107
            },
            "paperFormat": {
                "id": 5,
                "price": "333.19",
                "discount": "4.19",
                "quantity": 162,
                "pageCount": 673
            },
            "publisherId": 5,
            "categoryId": 13
        },
];
const meta = {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost/api/v1/books?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://localhost/api/v1/books",
        "per_page": 10,
        "to": 6,
        "total": 6
};

const INFO = 'info';
const ELECTRONIC_BOOKS = 'electronic_books';
const AUDIO_BOOKS = 'audio_books';
const ORDER_HISTORY = 'order_history';
const LIKED_BOOKS = 'liked_books';

const activeTab = ref(INFO);


const updateData = async () => {
    console.log('update data');
    // send data to back with user token 
    // try {
    //     const response = await axios.put('/users', user, )
    // } catch(e) {
    //     console.log('errrorrrrr', e);
    // }
}

const updatePassword = async () => {
    console.log('update password');

    // send data to back with user token 
    // try {
    //     const response = await axios.put()
    // } catch(e) {
    //     console.log('errrorrrrr', e);
    // }
}

</script>

<template>
    <div>
        <div class="tab_buttons">
            <button @click="activeTab=INFO" class="btn btn-success me-1">Info</button>
            <button @click="activeTab=ELECTRONIC_BOOKS" class="btn btn-success me-1">Electronic Books</button>
            <button @click="activeTab=AUDIO_BOOKS" class="btn btn-success me-1">Audio Books</button>
            <button @click="activeTab=ORDER_HISTORY" class="btn btn-success me-1">Order history</button>
            <button @click="activeTab=LIKED_BOOKS" class="btn btn-success">Liked books</button>
        </div>
        <section class="pt-2" v-if="activeTab===INFO">
            <form class="profile_form">
                <div class="mb-3 fw-bold">{{user.firstName + " " + user.lastName}}</div>

                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name:</label>
                    <input type="text" class="form-control" id="firstName" :value="user.firstName">
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name:</label>
                    <input type="text" class="form-control" id="lastName" :value="user.lastName">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" :value="user.email">
                </div>
                <div class="mb-3">
                    <label for="phoneNumber" class="form-label">Phone Number:</label>
                    <input type="tel" class="form-control" id="phoneNumber" :value="user.phoneNumber">
                </div>

                <button class="btn btn-primary me-1" @click.prevent="updateData">
                    Save
                </button>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Change Password
                </button>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="currentPassword" class="form-label">Current Password:</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="currentPassword" 
                                        v-model="passwordData.currentPassword"
                                        >
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">New Password:</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="newPassword"
                                        v-model="passwordData.newPassword"
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="newPasswordConfirmation" class="form-label">Confirm New Password:</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="newPasswordConfirmation"
                                        v-model="passwordData.newPasswordConfirmation"
                                    >
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="updatePassword">Save new password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <section v-if="activeTab===ELECTRONIC_BOOKS">
            Electronic books tab
            <UsersBookList 
                :books
                :meta
            />
        </section>

        <section v-if="activeTab===AUDIO_BOOKS">
            Audio books tab
            <UsersBookList
                :books
                :meta
            />
        </section>

        <section v-if="activeTab===ORDER_HISTORY">
            Orders history tab
            <OrderList/>
        </section>

        <section v-if="activeTab===LIKED_BOOKS">
            Liked books
            <BookList
                :books
                :meta
            />
        </section>
            
    </div>
</template>

<style scoped>
    .profile_form {
        margin: 0 auto;
        width: 50%;
    }
    .tab_buttons {
        display: flex;
        justify-content: center;
        margin: 10px 0;
    }
</style>