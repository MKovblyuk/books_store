<?php

namespace App\Factories;

use App\Enums\ShippingMethods;
use App\Models\V1\Addresses\Country;
use App\Models\V1\Addresses\DeliveryPlace;
use App\Models\V1\Addresses\District;
use App\Models\V1\Addresses\Region;
use App\Models\V1\Addresses\Settlement;
use App\Models\V1\Orders\ShippingMethod;

abstract class AddressFromShippingServiceFactory
{
    protected ShippingMethod $shippingMethod;

    public function __construct()
    {
        $this->shippingMethod = ShippingMethod::where('name', $this->getShippingMethod()->value)->first();
    }

    abstract public function getShippingMethod(): ShippingMethods;

    abstract public function createCountry(array $data): Country;
    abstract public function createRegion(array $data, $countryId): Region;
    abstract public function createDistrict(array $data, $regionId): District;
    abstract public function createSettlement(array $data, $districtId): Settlement;
    abstract public function createDelivryPlace(array $data, $settlementId): DeliveryPlace;
}