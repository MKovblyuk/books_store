<script setup>
import SimpleLineChart from '@/components/widgets/charts/SimpleLineChart.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const labels = ref([]);
const data = ref([]);


onMounted(() => {
    fetchUsersRegistrationInfo();
});

async function fetchUsersRegistrationInfo() {
    const response = await axios.get('users/registration');

    if (response.status === 200) {
        labels.value = response.data.data.map(item => item.creationDate);
        data.value = response.data.data.map(item => item.usersCount);
    }
}

</script>

<template>
    <div>
        <div class="mb-2">
            Users Registration Chart
        </div>
        <SimpleLineChart
            :labels
            :data
            data-set-label="Users"
            y-title="Number of new users"
        />
    </div>
</template>