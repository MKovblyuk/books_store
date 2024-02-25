<?php

namespace Database\Factories\Books;

use App\Models\Books\Category;
use App\Models\Books\Publisher;
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
            'cover_image_url' => fake()->optional(0.8)->imageUrl(),
            'published_at' => fake()->optional(0.8)->dateTime(),
            'publisher_id' => Publisher::all()->random()->id,
            'category_id' => Category::where('name', '!=', 'root_category')->get()->random()->id,
        ];
    }
}
