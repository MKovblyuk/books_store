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
                'created_at',
                'updated_at',
                'details',
                'delivery_place_id',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact("user_id"),
                AllowedFilter::exact('delivery_place_id'),
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
                'books',
                'details',
                'deliveryPlace',
            ])
            ->paginate($per_page);
    }
}