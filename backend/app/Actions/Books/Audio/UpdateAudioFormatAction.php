<?php

namespace App\Actions\Books\Audio;

use App\Models\V1\Books\Book;
use Illuminate\Support\Facades\DB;

class UpdateAudioFormatAction
{
    public function execute(Book $book, array $attributes)
    {
        DB::transaction(function () use ($book, $attributes) {
            $book->audioFormat->update($attributes);
            
            if (isset($attributes['files'])) {
                $book->audioFormat->getFileStorageService()->delete();
                $book->audioFormat->getFileStorageService()->store($attributes['files']);
            }
        });
    }
}