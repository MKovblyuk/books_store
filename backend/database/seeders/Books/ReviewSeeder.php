<?php

namespace Database\Seeders\Books;

use App\Models\V1\Books\Book;
use App\Models\V1\Books\Review;
use App\Models\V1\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public const REVIEWS_COUNT = 20;

    public function run(): void
    {
        for ($i = 0; $i < self::REVIEWS_COUNT; $i++) {
            Review::factory()
                ->for(User::all()->random())
                ->for(Book::all()->random())
                ->create();
        }
    }
}
