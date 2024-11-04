<?php

namespace Database\Seeders\Books\AdditionalSeeders;

use App\Actions\Books\UpdateBookCoverImageAction;
use App\Models\V1\Books\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CoverImageSeeder
{
    /**
     * Seed cover image for book
     */
    public static function seed(Book $book): void
    {
        $files = Storage::disk('public')->allFiles('seeding_files/cover_images/');
        $filePath = $files[array_rand($files)];

        $coverImage = new UploadedFile(public_path('storage/' . $filePath), basename($filePath));
        app(UpdateBookCoverImageAction::class)->execute($book, $coverImage);
    }
}