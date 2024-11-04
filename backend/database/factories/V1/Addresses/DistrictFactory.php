<?php

namespace Database\Factories\V1\Addresses;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
        $districts = json_decode(Storage::disk('public')->get('seeding_files/json_files/districts.json'));

        return [
            'name' => fake()->unique()->randomElement($districts),
        ];
    }
}
