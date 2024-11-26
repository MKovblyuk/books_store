<?php

namespace App\Actions\Books\Audio;

use App\Helpers\DirectoryNameGenerator;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Book;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StoreAudioFormatAction
{
    public function __construct(
        private DirectoryNameGenerator $dirNameGenerator
    )
    {}

    public function execute(Book $book, array $attributes)
    {
        if ($book->electronicFormat) {
            throw new InvalidArgumentException('Audio format already exists for this book');
        }

        DB::transaction(function () use ($book, $attributes) {
            $attributes['path'] = $this->dirNameGenerator->generate($book->id, $book->name);
            $format = $book->audioFormat()->save(new AudioFormat($attributes));
            $format->getFileStorageService()->store($attributes['files']);
        });
    }
}