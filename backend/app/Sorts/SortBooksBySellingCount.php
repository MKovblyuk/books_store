<?php

namespace App\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBooksBySellingCount implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $q = $query->getQuery();
        $asterisk = empty($q->bindings['select']) && empty($q->columns) ? 'books.* ,' : '';

        $query->leftJoin('book_order', 'books.id', '=', 'book_order.book_id')
            ->addSelect(DB::raw($asterisk . ' SUM(book_order.quantity) as selling_count'))
            ->groupBy('books.id')
            ->orderBy('selling_count', $descending ? 'desc' : 'asc')
            ->orderBy('books.id');
    }
}