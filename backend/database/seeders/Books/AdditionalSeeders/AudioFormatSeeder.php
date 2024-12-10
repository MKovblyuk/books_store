<?php

namespace Database\Seeders\Books\AdditionalSeeders;

use App\Helpers\DirectoryNameGenerator;
use App\Models\V1\Books\AudioFormat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AudioFormatSeeder
{
    protected static $directories = [];

    /**
     * Seed Audio Format for Book
     */
    public static function seed(Collection $books): void
    {
        $data = [];

        foreach ($books as $book) {
            $dirName = app(DirectoryNameGenerator::class)->generate(now()->getTimestamp(), $book->id);
            Storage::disk('audio')->makeDirectory($dirName);
            self::$directories[] = $dirName;

            link(
                storage_path('app/public/seeding_files/audio_book_file.mp3'),
                Storage::disk('audio')->path($dirName .'/link_to_file.pdf')
            );

            $data[] = [
                ...AudioFormat::factory()->for($book)->make()->toArray(),
                'path' => $dirName,
            ];
        }

        DB::table('audio_formats')->insert($data);
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
            Storage::disk('audio')->deleteDirectory($directory);
        }

        self::$directories = [];
    }
}