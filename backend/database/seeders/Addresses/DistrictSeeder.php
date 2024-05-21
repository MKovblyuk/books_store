<?php

namespace Database\Seeders\Addresses;

use App\Models\V1\Addresses\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        District::factory(10)->create();
    }
}
