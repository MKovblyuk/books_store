<?php

namespace App\Filters;

use App\Enums\BookFormat;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBooksByFormats implements Filter{

    public function __invoke(Builder $query, $value, string $property)
    {
        if (is_array($value)) {
            foreach ($value as $item) {
                $format = BookFormat::tryFrom(ucfirst(strtolower($item)));
                $this->addFormatToQuery($query, $format);
            }

        } else {
            $format = BookFormat::tryFrom(ucfirst(strtolower($value)));
            $this->addFormatToQuery($query, $format);
        }
    }

    private function addFormatToQuery(Builder $query, BookFormat $format) 
    {
        if ($format === BookFormat::Paper) {
            $query->orWhereHas('paperFormat');
        }
        if ($format === BookFormat::Audio) {
            $query->orWhereHas('audioFormat');
        }
        if ($format === BookFormat::Electronic) {
            $query->orWhereHas('electronicFormat');
        }
    }
}