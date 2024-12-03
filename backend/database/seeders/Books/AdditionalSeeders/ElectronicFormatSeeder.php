<?php

namespace Database\Seeders\Books\AdditionalSeeders;

use App\Helpers\DirectoryNameGenerator;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use Illuminate\Http\UploadedFile;

class ElectronicFormatSeeder
{
    /**
     * Seed Electronic Format for Book
     */
    public static function seed(Book $book): void
    {
        $electronicFormat = ElectronicFormat::factory()->for($book)->create([
            'path' => app(DirectoryNameGenerator::class)->generate($book->id, $book->name)
        ]);

        $filePath = public_path('storage/seeding_files/electronic_book_file.pdf');
        $file = new UploadedFile($filePath, basename($filePath));
        $electronicFormat->getFileStorageService()->store([$file]);

        self::changePermissions();
    }

    private static function changePermissions(): void
    {
        shell_exec('chown -R www-data:www-data storage/app/books');
    }
}