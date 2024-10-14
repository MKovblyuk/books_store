<?php

namespace App\Actions\Addresses;

use App\Models\V1\Addresses\District;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetDistrictsAction
{
    public function execute()
    {
        return QueryBuilder::for(District::class)
        ->allowedFields([
            'id', 
            'name', 
            'region_id',
        ])
        ->allowedFilters([
            'id', 
            'name', 
            AllowedFilter::exact('region_id')
        ])
        ->allowedSorts([
            'id', 
            'name', 
            'region_id',
        ])
        ->allowedIncludes([
            'region',
        ])
        ->get();
    }
}