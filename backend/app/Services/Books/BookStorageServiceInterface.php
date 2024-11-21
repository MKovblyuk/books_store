<?php 

namespace App\Services\Books;

// use App\Models\V1\Books\Book;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface BookStorageServiceInterface
{
    public function store(array $files);
    
    public function download(string $extension): StreamedResponse;

    public function delete(): bool;

    public function getAllFiles(): array;
}