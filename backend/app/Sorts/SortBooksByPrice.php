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

        $defaultValue = $descending ? 0 : 99999999.99;
        $sqlFunction = $descending ? 'GREATEST' : 'LEAST';
        $sqlFunctionBody = '';

        foreach ($this->getFilteringFormats() as $format_table) {
            $sqlFunctionBody .= 'COALESCE((SELECT `price` FROM `'.$format_table.'` WHERE `'.$format_table.'`.`book_id` = `books`.`id`),'.$defaultValue.'),';
        }

        $query->addSelect(DB::raw(
            $asterisk . $sqlFunction . '('. $sqlFunctionBody . $defaultValue.') as `price`'
        ))
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