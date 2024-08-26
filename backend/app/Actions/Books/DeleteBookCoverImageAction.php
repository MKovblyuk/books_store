<?php

namespace App\Actions\Books;

use App\Models\V1\Books\Book;
use Illuminate\Support\Facades\Storage;

class DeleteBookCoverImageAction
{
    public function execute(Book $book): bool
    {
        return Storage::disk('preview_fragments')->delete($book->cover_image_path);
    }
}