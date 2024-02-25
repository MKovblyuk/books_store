<?php

namespace Database\Factories\Books;

use App\Models\Books\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Books\Review>
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
        return [
            'rating' => rand(1, 5),
            'review' => fake()->text(),
            'user_id' => User::all()->random()->id,
            'book_id' => Book::all()->random()->id,
        ];
    }
}
