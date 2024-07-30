<?php

namespace App\Services\Books;

use App\Models\V1\Books\Book;
use App\Traits\FileStorage;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AudioBookStorageService implements BookStorageServiceInterface
{
    use FileStorage;

    public function store(Book $book, array $files)
    {
        $dirName = $book->audioFormat->path;
        $this->storeFiles(Storage::disk('audio'), $dirName, $files);
    }

    public function download(Book $book, string $extension): StreamedResponse
    {
        $dirName = $book->audioFormat->path;
        return $this->downloadFile(Storage::disk('audio'), $dirName, $extension, $book->name);
    }
}