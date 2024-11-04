<?php

namespace Database\Seeders\Books;

use App\Enums\BookFormat;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\Category;
use App\Models\V1\Books\Publisher;
use Database\Seeders\Books\AdditionalSeeders\AudioFormatSeeder;
use Database\Seeders\Books\AdditionalSeeders\CoverImageSeeder;
use Database\Seeders\Books\AdditionalSeeders\ElectronicFormatSeeder;
use Database\Seeders\Books\AdditionalSeeders\PaperFormatSeeder;
use Exception;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedBooksWithFormats(3, [BookFormat::Audio, BookFormat::Electronic, BookFormat::Paper]);
        $this->seedBooksWithFormats(3, [BookFormat::Audio, BookFormat::Electronic]);
        $this->seedBooksWithFormats(3, [BookFormat::Paper]);
    }

    private function seedBooksWithFormats(int $count, array $formats): void
    {
        for ($i = 0; $i < $count; $i++) {
            $this->seedBookWithFormats($formats);
        }
    }

    private function seedBookWithFormats(array $formats): void
    {
        $book = $this->createBook();

        foreach ($formats as $format) {
            switch ($format) {
                case BookFormat::Audio : AudioFormatSeeder::seed($book); break;
                case BookFormat::Electronic : ElectronicFormatSeeder::seed($book); break;
                case BookFormat::Paper: PaperFormatSeeder::seed($book); break;
                default : throw new Exception('Incorrect Book Format');
            }
        }
    }

    private function createBook(): Book
    {
        $book = Book::factory()
            ->hasAttached(Author::all()->random(2))
            ->for(Publisher::all()->random())
            ->for(Category::all()->random())
            ->create();

        CoverImageSeeder::seed($book);        
        
        return $book;
    }
}
