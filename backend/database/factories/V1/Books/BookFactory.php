<?php

namespace Database\Factories\V1\Books;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Books\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $languages = [
            'Ukrainian',
            'English',
            'German',
            'Italian',
            'French',
        ];

        return [
            'name' => fake()->text(25),
            'description' => fake()->text(),
            'publication_year' => fake()->year(),
            'language' => $languages[array_rand($languages)], 
            'cover_image_path' => fake()->filePath(),
            'published_at' => fake()->optional(0.8)->date,
        ];
    }
}
