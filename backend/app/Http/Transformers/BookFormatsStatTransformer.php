<?php

namespace App\Http\Transformers;

// use Illuminate\Database\Eloquent\Collection;

class BookFormatsStatTransformer extends StatTransformer
{
    protected function transformDataItem($item): array
    {
        return [
            'format' => $item->book_format,
            'soldCount' => $item->books_sold_count,
        ];
    }
    // public static function transform(Collection $collection): array
    // {
    //     return self::convertToReadable($collection);
    // }

    // private static function convertToReadable(Collection $collection): array
    // {
    //     $readable = [];
    //     $years = $collection->map(fn ($item) => $item->year)->unique();
        
    //     foreach ($years as $year) {
    //         $months = self::getMonthsData($collection->filter(fn ($item) => $item->year === $year));

    //         $readable[] = [
    //             'year' => $year,
    //             'months' => $months
    //         ];
    //     }

    //     return $readable;
    // }

    // private static function getMonthsData(Collection $collection): array
    // {
    //     $res = [];
    //     $months = $collection->map(fn ($item) => $item->month)->unique();

    //     foreach ($months as $month) {
    //         $formats = self::getFormatsData($collection->filter(fn ($item) => $item->month === $month));

    //         $res[] = [
    //             'month' => $month,
    //             'formats' => $formats
    //         ];
    //     }

    //     return $res;
    // }

    // private static function getFormatsData(Collection $collection): array
    // {
    //     return $collection->map(fn ($item) => [
    //         'format' => $item->book_format,
    //         'soldCount' => $item->books_sold_count,
    //     ])->values()->toArray();
    // }
}