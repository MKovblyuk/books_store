<?php

namespace Database\Seeders\Addresses;

use App\Models\V1\Addresses\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::factory(10)->create();
    }
}
