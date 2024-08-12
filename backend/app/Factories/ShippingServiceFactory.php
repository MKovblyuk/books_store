<?php

namespace App\Factories;

use App\Enums\ShippingMethods;
use App\Services\Orders\NovaposhtaService;
use App\Services\Orders\ShippingServiceInterface;
use App\Services\Orders\UkrposhtaService;
use Exception;

class ShippingServiceFactory
{
    public static function create(ShippingMethods $shippingMethod): ShippingServiceInterface
    {
        switch ($shippingMethod) {
            case ShippingMethods::NovaPoshta : return new NovaposhtaService();
            case ShippingMethods::UkrPoshta : return new UkrposhtaService();
            default: throw new Exception('Wrong Shipping method passed');
        }
    }
}