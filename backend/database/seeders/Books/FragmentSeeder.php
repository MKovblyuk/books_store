<?php

namespace Database\Seeders\Books;

use App\Actions\Books\StoreFragmentsAction;
use App\Models\V1\Books\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FragmentSeeder extends Seeder
{
    private array $files;
    private StoreFragmentsAction $storeFragmentAction;

    public const FRAGMENTS_COUNT = 3;

    public function __construct(StoreFragmentsAction $storeFragmentAction)
    {
        $this->storeFragmentAction = $storeFragmentAction;
        $this->files = Storage::disk('public')->allFiles('seeding_files/preview_fragments/');
    }

    public function run(): void
    {    
        Book::withoutEagerLoads()->get(['id'])->chunk(1000)->each(function (Collection $books) {
            $this->seedFragmentsForBooks($books->toArray(), self::FRAGMENTS_COUNT);
        });
    }

    private function seedFragmentsForBooks(array $books, $count = 1): void
    {
        $mappedBooks = array_map(function ($book) use ($count) {
            for ($i = 0 ; $i < $count; $i++) {
                $filePath = $this->files[array_rand($this->files)];
                $fragmentFile = new UploadedFile(public_path('storage/' . $filePath), basename($filePath));
                
                $book['fragments'][] = $fragmentFile;
            }

            return $book;
        }, $books);

        $this->storeFragmentAction->execute($mappedBooks);
    }
}
