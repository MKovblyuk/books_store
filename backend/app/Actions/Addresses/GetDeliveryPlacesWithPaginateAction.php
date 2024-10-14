<?php

namespace App\Actions\Addresses;

use App\Models\V1\Addresses\DeliveryPlace;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetDeliveryPlacesWithPaginateAction
{
    public function execute(int $perPage)
    {
        return QueryBuilder::for(DeliveryPlace::class)
            ->allowedFields([
                'id', 
                'street_address', 
                'settlement_id',
                'shipping_method_id',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('settlement_id'),
                AllowedFilter::exact('shipping_method_id'),
                'street_address',
            ])
            ->allowedSorts([
                'id',
                'street_address',
                'settlement_id',
                'shipping_method_id',
            ])
            ->allowedIncludes([
                'settlement',
                'shippingMethod',
            ])
            ->paginate($perPage);
    }
}