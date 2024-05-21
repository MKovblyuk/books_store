<?php

namespace App\Repositories;

use App\Enums\BookFormat;
use App\Events\Orders\OrderCreated;
use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Models\V1\Books\Book;
use App\Models\V1\Orders\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderRepository implements OrderRepositoryInterface
{
    public function getAll() : Collection
    {
        return QueryBuilder::for(Order::class)
            ->allowedFields(
                'id',
                'status',
                'user_id',
                'address_id',
                'shipping_method_id',
                'created_at',
                'updated_at'
            )
            ->allowedFilters(
                AllowedFilter::exact('id'),
                AllowedFilter::exact("user_id"),
                AllowedFilter::exact('address_id'),
                AllowedFilter::exact('shipping_method_id'),
                AllowedFilter::exact('created_at'),
                AllowedFilter::exact('updated_at'),
                'status',
            )
            ->allowedSorts(
                'id',
                'created_at',
                'updated_at'
            )
            ->allowedIncludes(
                'user',
                'shippingMethod',
                'books'
            )
            ->get();
    }
}
