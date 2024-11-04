<?php

namespace Database\Seeders\Books;

use App\Actions\Books\StoreFragmentAction;
use App\Models\V1\Books\Book;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FragmentSeeder extends Seeder
{
    private array $files;
    private StoreFragmentAction $storeFragmentAction;

    public function __construct(StoreFragmentAction $storeFragmentAction)
    {
        $this->storeFragmentAction = $storeFragmentAction;
        $this->files = Storage::disk('public')->allFiles('seeding_files/preview_fragments/');
    }

    public function run(): void
    {    
        foreach (Book::all() as $book) {
            $this->seedFragmentsForBook($book, 3);
        }
    }

    private function seedFragmentsForBook(Book $book, $count = 1): void
    {
        for ($i = 0; $i < $count; $i++) {
            $filePath = $this->files[array_rand($this->files)];
            $fragmentFile = new UploadedFile(public_path('storage/' . $filePath), basename($filePath));
    
            $this->storeFragmentAction->execute($book->id, $fragmentFile);
        }
    }
}
