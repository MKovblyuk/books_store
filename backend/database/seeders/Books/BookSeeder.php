<?php

namespace Database\Seeders\Books;

use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use App\Models\V1\Books\PaperFormat;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createBooksWithFormats(20, PaperFormat::class);
        $this->createBooksWithFormats(20, PaperFormat::class, ElectronicFormat::class);
        $this->createBooksWithFormats(20, PaperFormat::class, AudioFormat::class, ElectronicFormat::class);
    }

    private function createBookWithFormats(string ...$formatClasses): void
    {
        $authors = Author::all()->random(2);
        $book = Book::factory()
            ->hasAttached($authors)
            ->create();

        foreach($formatClasses as $formatClass) {
            $formatClass::factory()->create(['book_id' => $book->id]);
        }
    }

    private function createBooksWithFormats(int $booksCount, string ...$formatClasses): void
    {
        for ($i = 0; $i < $booksCount; $i++) {
            $this->createBookWithFormats(...$formatClasses);
        }
    }
}
