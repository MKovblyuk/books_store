<?php

namespace Database\Seeders\Addresses;

use App\Models\V1\Addresses\Country;
use App\Models\V1\Addresses\DeliveryPlace;
use App\Models\V1\Addresses\District;
use App\Models\V1\Addresses\Region;
use App\Models\V1\Addresses\Settlement;
use App\Models\V1\Orders\ShippingMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seed by fake data
 */
class TestAddressSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $country = Country::factory(['name' => 'Україна'])->create();
            $regions = Region::factory(3)->for($country)->create();
    
            $regions->each(function ($region) {
                $districts = District::factory(3)->for($region)->create();
    
                $districts->each(function ($district) {
                    $settlements = Settlement::factory(3)->for($district)->create();
    
                    $settlements->each(function ($settlement) {
                        DeliveryPlace::factory(3)
                            ->for(ShippingMethod::all()->random())
                            ->for($settlement)
                            ->create();
                    });
                });
            });
        });
    }
}
