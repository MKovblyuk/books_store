<?php

namespace App\Services\Orders;

interface PriceCalculatorInterface 
{
    public function calculate(array $data): float;
}