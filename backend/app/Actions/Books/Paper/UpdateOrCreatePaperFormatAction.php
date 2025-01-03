<?php

namespace App\Actions\Books\Paper;

use App\Models\V1\Books\Book;
use App\Models\V1\Books\PaperFormat;

class UpdateOrCreatePaperFormatAction
{
    public function execute(Book $book, array $attributes)
    {
        PaperFormat::updateOrCreate(
            ['book_id' => $book->id],
            $attributes
        );
    }
}