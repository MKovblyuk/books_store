<?php

namespace Database\Seeders\Addresses;

use App\Models\V1\Addresses\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::factory(20)->create();
    }
}
