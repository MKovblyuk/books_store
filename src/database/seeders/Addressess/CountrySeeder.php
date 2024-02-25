<?php

namespace Database\Seeders\Addressess;

use App\Models\Addressess\Country;
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
