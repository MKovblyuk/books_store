<?php

namespace App\Services\Orders;

interface ShippingServiceInterface
{
    public function getCountries(): array;
    public function getRegions($country): array;
    public function getDistricts($region): array;
    public function getSettlements($district): array;
    public function getDeliveryPlaces($settlement): array;
}