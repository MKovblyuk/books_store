<?php

namespace App\Actions\Books;

use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use Illuminate\Support\Facades\DB;

class UpdateBookAction 
{
    public function execute(Book $book, array $attributes): bool
    {
        return DB::transaction(function () use($book, $attributes) {      
            $book->update($attributes);
            $book->authors()->sync(Author::find($attributes['authors_ids']));

            if (isset($attributes['formats']['paper'])) {
                $book->paperFormat->update($attributes['formats']['paper']);
            }
            if (isset($attributes['formats']['audio'])) {
                $book->audioFormat->update($attributes['formats']['audio']);
            }
            if (isset($attributes['formats']['electronic'])) {
                $book->electronicFormat->update($attributes['formats']['electronic']);
            }

            return true;
        });
    }
}