<?php

namespace Database\Factories\V1\Addresses;

use App\Models\V1\Addresses\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Addressess\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'settlement_name' => fake()->city(),
            'street_name' => fake()->streetName(),
            'street_number' => rand(1,50),
            'postal_code' => fake()->unique()->postcode(),
            'district_id' => District::all()->random()->id,
        ];
    }
}
