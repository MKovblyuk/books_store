<?php 

namespace App\Services\Books;

use App\Models\V1\Books\Book;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface BookStorageServiceInterface
{
    public function store(Book $book, array $files);
    
    public function download(Book $book, string $extension): StreamedResponse;

    public function delete(Book $book): bool;

    public function getAllFiles(Book $book): array;
}