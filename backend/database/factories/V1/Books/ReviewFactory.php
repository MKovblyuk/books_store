<?php

namespace Database\Factories\V1\Books;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Books\'review'>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reviews = json_decode(Storage::disk('public')->get('seeding_files/json_files/reviews.json'), true);
        return $reviews[array_rand($reviews)];
    }
}
