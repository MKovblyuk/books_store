<?php

namespace App\Filters;

use App\Enums\BookFormat;
use App\Models\V1\Books\Book;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBooksByPrice implements Filter{

    private BookFormat $format;

    public function __construct(BookFormat $format = null)
    {
        $this->format = $format;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $range = is_array($value) ? $value : explode(',', $value);
        $price_from = $range[0];
        $price_to = isset($range[1]) && $range[1] >= $price_from ? $range[1] : false;


        if ($this->format === BookFormat::Paper) {
            $query->whereHas('paperFormat', function (Builder $query) use ($price_from, $price_to) {
                $this->wherePriceInRange($query, $price_from, $price_to);
            });
        } 
        if ($this->format === BookFormat::Audio) {
            $query->whereHas('audioFormat', function (Builder $query) use ($price_from, $price_to) {
                $this->wherePriceInRange($query, $price_from, $price_to);
            });
        }
        if ($this->format === BookFormat::Electronic) {
           $query->whereHas('electronicFormat', function (Builder $query) use ($price_from, $price_to) {
                $this->wherePriceInRange($query, $price_from, $price_to);
            });
        }
    }

    private function wherePriceInRange(Builder $query, float $price_from, float|bool $price_to) : void
    {
        $query->when($price_from, function (Builder $query) use ($price_from) {
            $query->where('price', '>', $price_from);
        })
        ->when($price_to, function (Builder $query) use ($price_to) {
            $query->where('price', '<', $price_to);
        });
    }
}