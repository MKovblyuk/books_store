<?php

namespace App\Sorts;

use App\Enums\BookFormat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBooksByPrice implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $q = $query->getQuery();
        $asterisk = empty($q->bindings['select']) && empty($q->columns) ? '* ,' : '';
        $sqlFunction = $descending ? 'MAX' : 'MIN';

        $subQuery = null;
        foreach ($this->getFilteringFormats() as $table_name) {
            $queryPart = DB::table($table_name)->select('book_id', 'price', 'discount');
    
            if ($subQuery === null) {
                $subQuery = $queryPart;
            } else {
                $subQuery->unionAll($queryPart);
            }
        }

        $query->select(DB::raw($asterisk . ' format_prices.price as price'))
            ->joinSub(
                function ($query) use ($subQuery, $sqlFunction) {
                    $query->selectRaw("book_id, $sqlFunction(price - (price * discount)) AS price")
                        ->fromSub($subQuery, 'all_format_prices')
                        ->groupBy('book_id');
                }, 'format_prices', 'books.id', '=', 'format_prices.book_id')

            ->orderBy('price', $descending ? 'desc' : 'asc');
    }

    private function getFilteringFormats(): array
    {
        if (isset(request()['filter']['format'])) {
            $formats = explode(',', request()['filter']['format']);
        } else {
            $formats = BookFormat::values();
        }

        return array_map(fn($item) => strtolower($item) . '_formats', $formats);
    }
}