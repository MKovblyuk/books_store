<?php

namespace App\Actions\Orders;

use App\Models\V1\Orders\Order;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetAllOrdersWithPaginateAction
{
    public function execute(int $per_page) 
    {
        return QueryBuilder::for(Order::class)
            ->allowedFields([
                'id',
                'status',
                'user_id',
                'address_id',
                'shipping_method_id',
                'created_at',
                'updated_at'
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact("user_id"),
                AllowedFilter::exact('address_id'),
                AllowedFilter::exact('shipping_method_id'),
                AllowedFilter::exact('created_at'),
                AllowedFilter::exact('updated_at'),
                'status',
            ])
            ->allowedSorts([
                'id',
                'created_at',
                'updated_at'
            ])
            ->allowedIncludes([
                'user',
                'shippingMethod',
                'books'
            ])
            ->paginate($per_page);
    }
}