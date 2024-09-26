<script setup>
import { onMounted, ref } from 'vue';
import UISelectWithLabel from '../ui/UISelectWithLabel.vue';
import axios from 'axios';

const emit = defineEmits(['delivery_place_id_changed']);

const countries = ref([]);
const regions = ref([]);
const districts = ref([]);
const settlements = ref([]);
const deliveryPlaces = ref([]);

onMounted(() => {
    fetchCountries();
});

async function fetchCountries() {
    const response = await axios.get('/countries');
    countries.value = response.data.data;
}

async function fetchRegions(countryId)
{
    const response = await axios.get('/regions?fields[regions]=id,name&filter[country_id]=' + countryId);
    regions.value = response.data.data;
}

async function fetchDistricts(regionId)
{
    const response = await axios.get('/districts?fields[districts]=id,name&filter[region_id]=' + regionId);
    districts.value = response.data.data;
}

async function fetchSettlements(districtId)
{
    const response = await axios.get('/settlements?filter[district_id]=' + districtId);
    settlements.value = response.data.data;
}

async function fetchDeliveryPlaces(settlementId) 
{
    const response = await axios.get('/deliveryPlaces?filter[settlement_id]=' + settlementId);
    deliveryPlaces.value = response.data.data.map(item => ({...item, name: item.streetAddress}));
}
</script>

<template>
    <div>
        <div class="row mt-3">
            <div class="col-6">
                <UISelectWithLabel
                    id="country_select"
                    default-title="Select Country"
                    :items="countries"
                    label-text="Country"
                    required="true"
                    @change="e => e.target.value != '' && fetchRegions(e.target.value)"
                />
            </div>
            <div class="col-6">
                <UISelectWithLabel
                    id="region_select"
                    default-title="Select Region"
                    :items="regions"
                    label-text="Region"
                    required="true"
                    @change="e => e.target.value != '' && fetchDistricts(e.target.value)"
                />
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6">
                <UISelectWithLabel
                    id="district_select"
                    default-title="Select District"
                    :items="districts"
                    label-text="Distrit"
                    required="true"
                    @change="e => e.target.value != '' && fetchSettlements(e.target.value)"
                />
            </div>
            <div class="col-6">
                <UISelectWithLabel
                    id="settlement_select"
                    default-title="Select Settlement"
                    :items="settlements"
                    label-text="Settlement"
                    required="true"
                    @change="e => e.target.value != '' && fetchDeliveryPlaces(e.target.value)"
                />
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <UISelectWithLabel
                    id="delivery_place_select"
                    default-title="Select Delivery Place"
                    :items="deliveryPlaces"
                    label-text="Delivery Places"
                    required="true"
                    @change="e => e.target.value != '' && emit('delivery_place_id_changed', e.target.value)"
                />
            </div>
        </div>
    </div>
</template>