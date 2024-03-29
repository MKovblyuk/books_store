<?php

namespace Database\Seeders\Addresses;

use App\Models\V1\Addresses\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Region::factory(10)->create();
    }
}
