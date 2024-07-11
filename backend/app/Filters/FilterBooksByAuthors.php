<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBooksByAuthors implements Filter{

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereHas('authors', function (Builder $query) use ($value, $property) {

            if (is_array($value)) {
                $query->whereIn($property, $value);
            } else {
                $query->where($property, $value);
            }
            
        });
    }

}