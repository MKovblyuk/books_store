<?php

namespace Database\Seeders\Books;

use App\Enums\BookFormat;
use App\Factories\CoverImageFactory;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\Category;
use App\Models\V1\Books\Publisher;
use Database\Seeders\Books\AdditionalSeeders\AudioFormatSeeder;
use Database\Seeders\Books\AdditionalSeeders\ElectronicFormatSeeder;
use Database\Seeders\Books\AdditionalSeeders\PaperFormatSeeder;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function __construct(
        private $coverImageFactory = new CoverImageFactory
    )
    {}

    public function run(): void
    {            
        DB::transaction(function () {
            try {
                $this->seedBooksWithFormats(1000, [BookFormat::Audio, BookFormat::Electronic, BookFormat::Paper]);
                $this->seedBooksWithFormats(1000, [BookFormat::Audio, BookFormat::Electronic]);
                $this->seedBooksWithFormats(50_000, [BookFormat::Paper]);
            } catch (Exception $e) {
                ElectronicFormatSeeder::rollback();
                AudioFormatSeeder::rollback();
                $this->coverImageFactory->rollback();
                throw $e;
            }
        });
    }

    private function seedBooksWithFormats(int $count, array $formats): void
    {
        for ($BATCH_SIZE = 1000; $count > 0; $count -= $BATCH_SIZE) {
            if ($count < $BATCH_SIZE) {
                $BATCH_SIZE = $count;
            }

            $books = Book::factory($BATCH_SIZE)
                ->for(Publisher::inRandomOrder()->first())
                ->for(Category::inRandomOrder()->first())
                ->sequence(fn () => ['cover_image_path' => $this->coverImageFactory->createLinkToImage()])
                ->create();

            $this->seedAuthorBookTable(rand(1, 3), $books);
            $this->seedBookFormats($formats, $books);
        }
    }

    private function seedBookFormats(array $formats, Collection $books): void
    {
        foreach ($formats as $format) {
            switch ($format) {
                case BookFormat::Audio : AudioFormatSeeder::seed($books); break;
                case BookFormat::Electronic : ElectronicFormatSeeder::seed($books); break;
                case BookFormat::Paper: PaperFormatSeeder::seed($books); break;
                default : throw new Exception('Incorrect Book Format');
            }
        }
    }

    private function seedAuthorBookTable(int $authorsCount, Collection $books): void
    {   
        $authors = Author::inRandomOrder()->limit($authorsCount)->pluck('id');
        $data = [];

        foreach ($books as $book) {
            for ($i = 0; $i < $authorsCount; $i++) {
                $data[] = [
                    'book_id' => $book->id, 
                    'author_id' => $authors[$i]
                ];
            }
        }

        DB::table('author_book')->insert($data);
    }
}
