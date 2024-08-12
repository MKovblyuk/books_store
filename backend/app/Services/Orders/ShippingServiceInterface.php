<?php

namespace App\Services\Orders;

interface ShippingServiceInterface
{
    public function send($data);
}