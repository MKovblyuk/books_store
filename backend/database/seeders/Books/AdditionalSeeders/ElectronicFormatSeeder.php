<?php

namespace Database\Seeders\Books\AdditionalSeeders;

use App\Helpers\DirectoryNameGenerator;
use App\Models\V1\Books\ElectronicFormat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ElectronicFormatSeeder
{
    protected static $directories = [];
    protected static $seedFilePath = 'app/public/seeding_files/electronic_book_file.pdf';

    public static function getSeedFile(): UploadedFile
    {
        return new UploadedFile(storage_path(self::$seedFilePath), 'file.pdf');
    }

    /**
     * Seed Electronic Format for Book
     */
    public static function seed(Collection $books): void
    {        
        $seedFile = self::getSeedFile();
        $data = [];
        
        foreach ($books as $book) {
            $dirName = app(DirectoryNameGenerator::class)->generate(now()->getTimestamp(), $book->id);
            // Storage::disk('electronic')->makeDirectory($dirName);
            self::$directories[] = $dirName;

            // symlink(
            //     storage_path('app/public/seeding_files/electronic_book_file.pdf'),
            //     Storage::disk('electronic')->path($dirName .'/link_to_file.pdf')
            // );

            $electronicFormat = ElectronicFormat::factory()->for($book)->make(['path' => $dirName]);
            $electronicFormat->getFileStorageService()->store([$seedFile]);

            $data[] = [
                ...$electronicFormat->toArray(),
                'path' => $electronicFormat->path,
            ];

        }

        DB::table('electronic_formats')->insert($data);
        self::changePermissions();
    }

    private static function changePermissions(): void
    {
        shell_exec('chown -R www-data:www-data storage/app/books');
    }

    /**
     * Remove all created directories and files
     */
    public static function rollback() 
    {
        foreach (self::$directories as $directory) {
            Storage::disk('electronic')->deleteDirectory($directory);
        }

        self::$directories = [];
    }
}