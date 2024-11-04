<?php

namespace Database\Factories\V1\Books;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
        $languages = json_decode(Storage::disk('public')->get('seeding_files/json_files/languages.json'));
        $descriptions = json_decode(Storage::disk('public')->get('seeding_files/json_files/book_descriptions.json'));
        $titles = json_decode(Storage::disk('public')->get('seeding_files/json_files/book_titles.json'));

        return [
            'name' => $titles[array_rand($titles)],
            'description' => $descriptions[array_rand($descriptions)],
            'publication_year' => fake()->year(),
            'language' => $languages[array_rand($languages)], 
            'published_at' => fake()->optional(0.8)->date,
        ];
    }
}
