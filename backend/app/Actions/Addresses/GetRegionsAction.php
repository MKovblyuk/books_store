<?php

namespace App\Actions\Addresses;

use App\Models\V1\Addresses\Region;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetRegionsAction
{
    public function execute()
    {
        return QueryBuilder::for(Region::class)
            ->allowedFields([
                'id', 
                'name', 
                'country_id',
            ])
            ->allowedFilters([
                'id', 
                'name', 
                AllowedFilter::exact('country_id'),
            ])
            ->allowedSorts([
                'id', 
                'name', 
                'country_id',
            ])
            ->allowedIncludes([
                'country',
            ])
            ->get();
    }
}