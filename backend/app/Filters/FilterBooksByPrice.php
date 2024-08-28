<?php

namespace App\Filters;

use App\Enums\BookFormat;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBooksByPrice implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $range = $this->validatePriceRange($value);

        $query->where(function (Builder $query) use ($range){
            foreach ($this->getFilteringFormats() as $format) {
                $query->orWhereHas($format, function (Builder $query) use($range) {
                    $query->whereRaw('price - (price * discount / 100) BETWEEN ? AND ?', $range);
                });
            }
        });
    }

    private function validatePriceRange($data): array
    {
        $range = is_array($data) ? $data : explode(',', $data);
        $price_from = $range[0];
        $price_to = isset($range[1]) && $range[1] >= $price_from ? $range[1] : PHP_FLOAT_MAX;

        return [(float)$price_from, (float)$price_to];
    }

    private function getFilteringFormats(): array
    {
        if (isset(request()['filter']['format'])) {
            $formats = explode(',', request()['filter']['format']);
        } else {
            $formats = BookFormat::values();
        }

        return array_map(fn($item) => strtolower($item) . 'Format', $formats);
    }
}