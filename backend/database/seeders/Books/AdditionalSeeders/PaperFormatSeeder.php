<?php

namespace Database\Seeders\Books\AdditionalSeeders;

use App\Models\V1\Books\Book;
use App\Models\V1\Books\PaperFormat;

class PaperFormatSeeder
{
    /**
     * Seed Paper Format for Book
     */
    public static function seed(Book $book): void
    {
        PaperFormat::factory()->for($book)->create();
    }
}