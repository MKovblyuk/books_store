<?php

namespace Database\Seeders\Books\AdditionalSeeders;

use App\Helpers\DirectoryNameGenerator;
use App\Models\V1\Books\ElectronicFormat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ElectronicFormatSeeder
{
    protected static $directories = [];

    /**
     * Seed Electronic Format for Book
     */
    public static function seed(Collection $books): void
    {        
        $data = [];
        
        foreach ($books as $book) {
            $dirName = app(DirectoryNameGenerator::class)->generate(now()->getTimestamp(), $book->id);
            Storage::disk('electronic')->makeDirectory($dirName);
            self::$directories[] = $dirName;

            symlink(
                storage_path('app/public/seeding_files/electronic_book_file.pdf'),
                Storage::disk('electronic')->path($dirName .'/link_to_file.pdf')
            );

            $data[] = [
                ...ElectronicFormat::factory()->for($book)->make()->toArray(),
                'path' => $dirName,
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