<?php

namespace App\Filters;

use App\Models\V1\Books\Category;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBooksByCategoryWithChild implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $childCategoriesIds = Category::find($value)->descendants()->pluck('id');
        $childCategoriesIds->push($value);

        $query->whereIn('category_id', $childCategoriesIds);
    }
}