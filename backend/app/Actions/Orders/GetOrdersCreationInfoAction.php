<?php

namespace App\Actions\Orders;

use App\Models\V1\Orders\Order;
use Illuminate\Database\Eloquent\Collection;

class GetOrdersCreationInfoAction
{
    public function execute(): Collection
    {
        return Order::query()
            ->selectRaw('count(id) as orders_count, DATE(created_at) as creation_date')
            ->groupBy('creation_date')
            ->get();
    }
}