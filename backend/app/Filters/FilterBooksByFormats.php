<?php

namespace App\Filters;

use App\Enums\BookFormat;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBooksByFormats implements Filter{
    
    public function __invoke(Builder $query, $value, string $property)
    {
        if (is_array($value)) {
            $query->where(function (Builder $query) use ($value) {
                foreach ($value as $item) {
                    $format = BookFormat::tryFrom(ucfirst(strtolower($item)));
                    $query->orWhereHas(strtolower($format->value) . 'Format');
                }
            });
        } else {
            $format = BookFormat::tryFrom(ucfirst(strtolower($value)));
            $query->whereHas(strtolower($format->value) . 'Format');
        }
    }
}