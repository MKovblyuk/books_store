<?php

namespace App\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBooksByLikes implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $q = $query->getQuery();
        $asterisk = empty($q->bindings['select']) && empty($q->columns) ? 'books.* ,' : '';

        $query->leftJoin('liked_books', 'books.id', '=', 'liked_books.book_id')
            ->addSelect(DB::raw($asterisk . ' COUNT(liked_books.book_id) as likes_count'))
            ->groupBy('books.id')
            ->orderBy('likes_count', $descending ? 'desc' : 'asc')
            ->orderBy('books.id');
    }
}