<?php

namespace Database\Seeders\Books;

use App\Models\Books\AudioFormat;
use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Books\ElectronicFormat;
use App\Models\Books\PaperFormat;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createBooksWithFormats(2, PaperFormat::class);
        $this->createBooksWithFormats(2, PaperFormat::class, ElectronicFormat::class);
        $this->createBooksWithFormats(2, PaperFormat::class, AudioFormat::class, ElectronicFormat::class); 
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
