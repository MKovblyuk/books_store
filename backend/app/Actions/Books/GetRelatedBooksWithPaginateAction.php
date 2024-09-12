<?php

namespace App\Actions\Books;

use App\Models\V1\Books\Book;
use Illuminate\Support\Facades\DB;

class GetRelatedBooksWithPaginateAction
{
    public function execute(Book $book, int $perPage)
    {
        $relatedCategoriesIds = $book->category->descendants()->pluck('id');
        $relatedCategoriesIds->push($book->category->id);

        return Book::query()
            ->whereNot('id',$book->id)
            ->orderByRaw('category_id IN (' . $relatedCategoriesIds->implode(',') . ') DESC')
            ->paginate($perPage);
    }

}