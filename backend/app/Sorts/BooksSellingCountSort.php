<?php

namespace App\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Sorts\Sort;

class BooksSellingCountSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $q = $query->getQuery();
        $asterisk = empty($q->bindings['select']) && empty($q->columns) ? '* ,' : '';

        $query->addSelect(DB::raw($asterisk .
            '(SELECT SUM(`book_order`.`quantity`)
            FROM `book_order`
            WHERE `books`.`id` = `book_order`.`book_id`
            ) as `selling_count`'
        ))
        ->orderBy('selling_count', $descending ? 'desc' : 'asc');
    }
}