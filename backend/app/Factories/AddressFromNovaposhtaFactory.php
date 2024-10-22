<?php

namespace App\Factories;

use App\Enums\ShippingMethods;
use App\Models\V1\Addresses\Country;
use App\Models\V1\Addresses\DeliveryPlace;
use App\Models\V1\Addresses\District;
use App\Models\V1\Addresses\PostalCode;
use App\Models\V1\Addresses\Region;
use App\Models\V1\Addresses\Settlement;
use Illuminate\Support\Facades\DB;

class AddressFromNovaposhtaFactory extends AddressFromShippingServiceFactory
{
    public function getShippingMethod(): ShippingMethods
    {
        return ShippingMethods::NovaPoshta;
    }

    public function createCountry(array $data): Country
    {
        return Country::firstOrCreate([
            'name' => $data['Description'],
        ]);
    }

    public function createRegion(array $data, $countryId): Region
    {
        return Region::firstOrCreate([
            'name' => $data['Description'],
            'country_id' => $countryId,
        ]);
    }

    public function createDistrict(array $data, $regionId): District
    {
        return District::firstOrCreate([
            'name' => $data['Description'],
            'region_id' => $regionId,
        ]);
    }

    public function createSettlement(array $data, $districtId): Settlement
    {
        return DB::transaction(function() use ($data, $districtId){
            $settlement = Settlement::firstOrCreate([
                'name' => $data['Description'],
                'district_id' => $districtId,
            ]);
    
            PostalCode::firstOrCreate(
                ['postal_code' => $data['Index1']],
                ['settlement_id' => $settlement->id,]
            );
    
            if ($data['Index1'] !== $data['Index2']) {
                PostalCode::firstOrCreate(
                    ['postal_code' => $data['Index2']],
                    ['settlement_id' => $settlement->id,]
                );
            }
    
            return $settlement;
        });
    }

    public function createDelivryPlace(array $data, $settlementId): DeliveryPlace
    {
        return DeliveryPlace::firstOrCreate([
            'street_address' => $data['Description'],
            'settlement_id' => $settlementId,
            'shipping_method_id' => $this->shippingMethod->id,
        ]);
    }
}