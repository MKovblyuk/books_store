<?php

namespace Database\Seeders\Addressess;

use App\Models\Addressess\District;
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
