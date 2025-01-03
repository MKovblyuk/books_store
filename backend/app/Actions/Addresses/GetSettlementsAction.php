<?php

namespace App\Actions\Addresses;

use App\Models\V1\Addresses\Settlement;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetSettlementsAction
{
    public function execute(int $perPage = null)
    {
        $query = QueryBuilder::for(Settlement::class)
            ->allowedFields([
                'id', 
                'name', 
                'district_id',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'), 
                AllowedFilter::exact('district_id'),
                'name',
            ])
            ->allowedSorts([
                'id', 
                'name', 
                'district_id',
            ])
            ->allowedIncludes([
                'district',
            ]);

        return $perPage ? $query->paginate($perPage) : $query->get();
    }
}