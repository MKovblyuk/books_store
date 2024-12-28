<?php

namespace App\Actions\Books;

use App\Models\V1\Books\Book;

class GetRelatedBooksAction
{
    public function execute(Book $book, int $limit)
    {
        $relatedCategoriesIds = $book->category->descendants()->pluck('id');
        $relatedCategoriesIds->push($book->category->id);

        $query2 = Book::query()
            ->select(['id', 'name', 'cover_image_path'])
            ->without('likedByUsers')
            ->whereNot('id', $book->id)
            ->whereNotIn('category_id', $relatedCategoriesIds);

        return Book::query()
            ->select(['id', 'name', 'cover_image_path'])
            ->without('likedByUsers')
            ->whereNot('id',$book->id)
            ->whereIn('category_id', $relatedCategoriesIds)
            ->union($query2)
            ->limit($limit)
            ->get();
    }

}