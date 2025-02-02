<?php

namespace App\Actions\Orders;

use App\Models\V1\Orders\Order;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetOrdersAction
{
    public function execute(int $perPage) 
    {
        return QueryBuilder::for(Order::class)
            ->allowedFields([
                'id',
                'status',
                'user_id',
                'created_at',
                'updated_at',
                'delivery_place_id',
                'payment_method_id',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact("user_id"),
                AllowedFilter::exact('delivery_place_id'),
                AllowedFilter::exact('payment_method_id'),
                AllowedFilter::exact('created_at'),
                AllowedFilter::exact('updated_at'),
                'status',
            ])
            ->allowedSorts([
                'id',
                'created_at',
                'updated_at',
                'total_price',
            ])
            ->allowedIncludes([
                'user',
                'books',
                'deliveryPlace',
                'paymentMethod',
            ])
            ->paginate($perPage);
    }
}