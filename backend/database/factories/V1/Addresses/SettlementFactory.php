<?php

namespace Database\Factories\V1\Addresses;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Addressess\Country>
 */
class SettlementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $settlements = json_decode(Storage::disk('public')->get('seeding_files/json_files/settlements.json'));

        return [
            'name' => fake()->unique()->randomElement($settlements),
        ];
    }
}
