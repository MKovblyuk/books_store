<?php

namespace Database\Factories\Books;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Books\PaperFormat>
 */
class PaperFormatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => rand(10, 500) + rand(1, 100) / 100,
            'discount' => rand(1, 9) + rand(1, 100) / 100,
            'page_count' => rand(60, 1200),
            'quantity' => rand(0, 400),
        ];
    }
}
