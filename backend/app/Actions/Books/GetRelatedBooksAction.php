<?php

namespace App\Actions\Books;

use App\Models\V1\Books\Book;
use Illuminate\Database\Eloquent\Collection;

class GetRelatedBooksAction
{
    public function execute(Book $book): Collection
    {
        $relatedCategoriesIds = $book->category->descendants()->pluck('id');
        $relatedCategoriesIds->push($book->category->id);
        
        return Book::query()->whereIn('category_id', $relatedCategoriesIds)->get();;
    }
}