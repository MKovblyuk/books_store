<?php

namespace Database\Factories\V1\Books;

use App\Models\V1\Books\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Books\Fragment>
 */
class FragmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => fake()->imageUrl(),
            'book_id' => Book::all()->random()->id,
        ];
    }
}
