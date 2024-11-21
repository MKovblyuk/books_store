<?php

namespace App\Services\Books;

use App\Models\V1\Books\Book;
use App\Traits\FileStorage;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ElectronicBookStorageService implements BookStorageServiceInterface
{
    use FileStorage;

    public function store(Book $book, array $files)
    {
        $dirName = $book->electronicFormat->path;
        $this->storeFiles(Storage::disk('electronic'), $dirName, $files);
    }

    public function download(Book $book, string $extension): StreamedResponse
    {
        $dirName = $book->electronicFormat->path;
        return $this->downloadFile(Storage::disk('electronic'), $dirName, $extension, $book->name);
    }

    public function delete(Book $book): bool
    {
        $dirName = $book->electronicFormat->path;
        return $this->deleteAllFiles(Storage::disk('electronic'), $dirName);
    }

    /**
     * Return files meta
     */
    public function getAllFiles(Book $book): array
    {
        $dirName = $book->audioFormat->path;
        return $this->getAllFilesMeta(Storage::disk('audio'), $dirName);
    }
}