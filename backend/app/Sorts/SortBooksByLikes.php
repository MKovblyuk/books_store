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
        $asterisk = empty($q->bindings['select']) && empty($q->columns) ? '* ,' : '';

        $query->addSelect(DB::raw($asterisk . 
            '(SELECT COUNT(*) 
            FROM `liked_books` 
            WHERE `liked_books`.`book_id` = `books`.`id` 
            ) as `likes_count`'
        ))
        ->orderBy('likes_count', $descending ? 'desc' : 'asc');
    }
}