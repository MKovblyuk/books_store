<?php

namespace App\Actions\Books;

use App\Models\V1\Books\Book;

class UpdateOrCreateElectronicFormatAction
{
    public function __construct(
        private StoreElectronicFormatAction $storeAction,
        private UpdateElectronicFormatAction $updateAction
    )
    {}

    public function execute(Book $book, array $attributes)
    {
        $book->electronicFormat 
            ? $this->updateAction->execute($book, $attributes)
            : $this->storeAction->execute($book, $attributes);
    }
}