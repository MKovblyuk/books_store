<?php

namespace Database\Seeders\Books\AdditionalSeeders;

use App\Helpers\DirectoryNameGenerator;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Book;
use Illuminate\Http\UploadedFile;

class AudioFormatSeeder
{
    /**
     * Seed Audio Format for Book
     */
    public static function seed(Book $book): void
    {
        $audioFormat = AudioFormat::factory()->for($book)->create([
            'path' => app(DirectoryNameGenerator::class)->generate($book->id, $book->name)
        ]);

        $filePath = public_path('storage/seeding_files/audio_book_file.mp3');
        $file = new UploadedFile($filePath, basename($filePath));
        $audioFormat->getFileStorageService()->store([$file]);

        self::changePermissions();
    }

    private static function changePermissions(): void
    {
        shell_exec('chown -R www-data:www-data storage/app/books');
    }
}