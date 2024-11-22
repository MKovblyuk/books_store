<?php

namespace App\Actions\Books;

use App\Models\V1\Books\Review;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetReviewsAction
{
    public function execute(int $perPage)
    {
        return QueryBuilder::for(Review::class)
            ->allowedFields([
                'id', 
                'rating', 
                'review', 
                'user_id', 
                'book_id', 
                'updated_at',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('rating'),
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('book_id'),
                'updated_at',
            ])
            ->allowedSorts([
                'id', 
                'rating', 
                'updated_at',
            ])
            ->allowedIncludes([
                'book'
            ])
            ->paginate($perPage);
    }
}