<?php

namespace Database\Seeders\Orders;

use App\Enums\ShippingMethods;
use App\Models\V1\Orders\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingMethod::create(['name' => ShippingMethods::NovaPoshta]);
        ShippingMethod::create(['name' => ShippingMethods::UkrPoshta]);
    }
}
