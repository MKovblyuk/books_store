<?php

namespace App\Actions\Publishers;

use App\Models\V1\Books\Publisher;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetPublishersAction
{
    public function execute(int $perPage = null)
    {
        $query = QueryBuilder::for(Publisher::class)
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
            ]);

        return $perPage ? $query->paginate($perPage) : $query->get();
    }
}