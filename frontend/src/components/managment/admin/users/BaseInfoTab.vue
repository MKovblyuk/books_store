<script setup>
import DeleteUserModal from '@/components/widgets/modals/DeleteUserModal.vue';
import PaginationBar from '@/components/widgets/PaginationBar.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import EditUserTab from './EditUserTab.vue';
import UserDetailsTab from './UserDetailsTab.vue';
import UsersTable from './UsersTable.vue';
import FilterUsersForm from './FilterUsersForm.vue';

const deleteModalRef = ref();
const showFilterForm = ref(false);

const users = ref([]);
const meta = ref();
const selectedUser = ref();

const PER_PAGE = 8;
const filterParams = ref({});
const sortParam = ref();

const MAIN_TAB = 'main_tab';
const EDIT_USER_TAB = 'edit_user_tab';
const USER_DETAILS_TAB = 'user_details_tab';
const activeTab = ref(MAIN_TAB);

onMounted(() => {
    fetchUsers();
})

async function fetchUsers(page = 1) {
    const response = await axios.get('/users', {
        params: {
            page: page,
            per_page: PER_PAGE,
            sort: sortParam.value,
            ...filterParams.value
        }
    });

    users.value = response.data.data;
    meta.value = response.data.meta;
}

function setFilterParams(data) {
    filterParams.value['filter[first_name]'] = data?.firstName;
    filterParams.value['filter[last_name]']  = data?.lastName;
    filterParams.value['filter[email]']  = data?.email;
    filterParams.value['filter[role]']  = data?.roles?.join(',');
    filterParams.value['filter[created_at]']  = data?.createdAt;
    filterParams.value['filter[updated_at]']  = data?.updatedAt;
}

function filterChangedHandler(data) {
    setFilterParams(data);
    fetchUsers();
}

function sortingChangedHandler(isAsc, column) {
    sortParam.value = (isAsc ? '-' : '') + column;
    fetchUsers();
}

function showEditUserTab(user) {
    selectedUser.value = user;
    activeTab.value = EDIT_USER_TAB;
}

function showUserDetailsTab(user) {
    selectedUser.value = user;
    activeTab.value = USER_DETAILS_TAB;
}

function showDeleteUserModal(user) {
    selectedUser.value = user;
    deleteModalRef.value.click();
}
</script>

<template>
    <div>
        <div class="mb-2">
            <button class="btn btn-primary mb-1" @click="showFilterForm = !showFilterForm">
                {{ showFilterForm ? 'Hide' : 'Search' }}
            </button>

            <FilterUsersForm
                v-show="showFilterForm"
                @filter-changed="filterChangedHandler"
            />
        </div>

        <div v-show="activeTab === MAIN_TAB">
            <UsersTable
                :users
                @sorting-changed="sortingChangedHandler"
                @edit-btn-clicked="showEditUserTab"
                @details-btn-clicked="showUserDetailsTab"
                @delete-btn-clicked="showDeleteUserModal"
            />

            <PaginationBar 
                v-if="meta"
                :meta
                @page_changed="newPage => fetchUsers(newPage)"
            />

            <button 
                hidden 
                data-bs-toggle="modal" 
                data-bs-target="#deleteModal"
                ref="deleteModalRef"
            ></button>
            <DeleteUserModal 
                title="Delete user" 
                ok-btn-text="Delete" 
                id="deleteModal"
                :user="selectedUser"
                @user-deleted="fetchUsers"
            />
        </div>

        <EditUserTab 
            v-if="activeTab === EDIT_USER_TAB"    
            class="mt-2"
            :user="selectedUser"
            @try-return="activeTab = MAIN_TAB"
            @userUpdated="fetchUsers"
        />

        <UserDetailsTab 
            v-if="activeTab === USER_DETAILS_TAB"
            class="mt-2"
            :user="selectedUser"
            @try-return="activeTab = MAIN_TAB"
        />
    </div>
</template>

<style scoped>
@media screen and (max-width:1400px) {
    table {
        font-size: 0.6rem !important;
    }
}
</style>