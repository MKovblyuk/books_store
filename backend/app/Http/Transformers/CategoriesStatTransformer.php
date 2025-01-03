<?php

namespace App\Http\Transformers;

// use Illuminate\Database\Eloquent\Collection;

class CategoriesStatTransformer extends StatTransformer
{
    protected function transformDataItem($item): array
    {
        return [
            'categoryId' => $item->category_id,
            'categoryName' => $item->category_name,
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
    //         $categories = self::getCategoriesData($collection->filter(fn ($item) => $item->month === $month));

    //         $res[] = [
    //             'month' => $month,
    //             'categories' => $categories
    //         ];
    //     }

    //     return $res;
    // }

    // private static function getCategoriesData(Collection $collection): array
    // {
    //     return $collection->map(fn ($item) => [
    //         'categoryId' => $item->category_id,
    //         'categoryName' => $item->category_name,
    //         'soldCount' => $item->books_sold_count,
    //     ])->values()->toArray();
    // }

    // private static function getFormatsData(Collection $collection): array
    // {
    //     return $collection->map(fn ($item) => [
    //         'format' => $item->book_format,
    //         'soldCount' => $item->books_sold_count,
    //     ])->values()->toArray();
    // }
}