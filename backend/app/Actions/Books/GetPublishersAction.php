<?php

namespace App\Actions\Books;

use App\Models\V1\Books\Publisher;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetPublishersAction
{
    public function execute()
    {
        return QueryBuilder::for(Publisher::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                'name',
            ])
            ->allowedFields([
                'id', 
                'name',
            ])
            ->allowedSorts([
                'id', 
                'name',
            ])
            ->get();
    }
}