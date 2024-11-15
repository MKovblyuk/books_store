<?php

namespace App\Http\Transformers;

use Illuminate\Database\Eloquent\Collection;

/**
 * Transform collection into array
 * grouped by years, months
 */
abstract class StatTransformer 
{
    public function transform(Collection $collection): array
    {
        $result = [];
        $years = $collection->map(fn ($item) => $item->year)->unique();
        
        foreach ($years as $year) {
            $months = $this->transformMonths($collection->filter(fn ($item) => $item->year === $year));

            $result[] = [
                'year' => $year,
                'months' => $months
            ];
        }

        return $result;
    }

    private function transformMonths(Collection $collection): array
    {
        $result = [];
        $months = $collection->map(fn ($item) => $item->month)->unique();

        foreach ($months as $month) {
            $data = $this->transformData($collection->filter(fn ($item) => $item->month === $month));

            $result[] = [
                'month' => $month,
                'data' => $data
            ];
        }

        return $result;
    }

    private function transformData(Collection $collection): array
    {
        return $collection->map(fn ($item) => $this->transformDataItem($item))->values()->toArray();
    }

    abstract protected function transformDataItem($item): array;
}