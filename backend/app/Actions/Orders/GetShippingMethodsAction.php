<?php

namespace App\Actions\Orders;

use App\Models\V1\Orders\ShippingMethod;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetShippingMethodsAction
{
    public function execute()
    {
        return QueryBuilder::for(ShippingMethod::class)
            ->allowedFields([
                'id', 
                'name',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'), 
                'name',
            ])
            ->allowedSorts([
                'id',
                'name',
            ])
            ->get();
    }
}