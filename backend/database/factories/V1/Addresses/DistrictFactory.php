<?php

namespace Database\Factories\V1\Addresses;

// use App\Models\V1\Addresses\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Addressess\District>
 */
class DistrictFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->state(),
            // 'region_id' => Region::all()->random()->id,
        ];
    }
}
