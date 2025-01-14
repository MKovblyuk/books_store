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
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    private SupportCollection $authors;
    private SupportCollection $publishers;
    private SupportCollection $categories;

    public function __construct(
        private $coverImageFactory = new CoverImageFactory
    )
    {
        $this->authors = Author::all('id')->pluck('id');
        $this->publishers = Publisher::all('id')->pluck('id');
        $this->categories = Category::whereNot('parent_id')->get('id')->pluck('id');
    }

    public function run(): void
    {            
        $start = microtime(true);
        DB::transaction(function () {
            try {
                $this->seedBooksWithFormats(1000, [BookFormat::Audio, BookFormat::Electronic, BookFormat::Paper]);
                $this->seedBooksWithFormats(1000, [BookFormat::Audio, BookFormat::Electronic]);
                $this->seedBooksWithFormats(1000, [BookFormat::Paper]);
            } catch (Exception $e) {
                ElectronicFormatSeeder::rollback();
                AudioFormatSeeder::rollback();
                $this->coverImageFactory->rollback();
                throw $e;
            }
        });
        $end = microtime(true);
        dd('execution time: ' . ($end - $start));
    }

    private function seedBooksWithFormats(int $count, array $formats): void
    {
        for ($BATCH_SIZE = 1000; $count > 0; $count -= $BATCH_SIZE) {
            if ($count < $BATCH_SIZE) {
                $BATCH_SIZE = $count;
            }

            $books = Book::factory($BATCH_SIZE)
                ->sequence(fn () => ['category_id' => $this->categories->random()])
                ->sequence(fn () => ['publisher_id' => $this->publishers->random()])
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
        $data = [];

        foreach ($books as $book) {
            $authorsForBook = $this->authors->random($authorsCount);

            for ($i = 0; $i < $authorsCount; $i++) {
                $data[] = [
                    'book_id' => $book->id, 
                    'author_id' => $authorsForBook[$i],
                ];
            }
        }

        DB::table('author_book')->insert($data);
    }
}
