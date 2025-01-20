<?php

namespace App\Actions\Orders;

use App\Models\V1\Orders\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GetOrdersCreationInfoAction
{
    public function execute(int $year = null, int $month = null): Collection
    {
        return Order::query()
            ->selectRaw(implode(',', [
                'count(id) as orders_count',
                'YEAR(created_at) as year',
                'MONTH(created_at) as month',
            ]))
            ->groupBy('year', 'month')
            ->when($year, function (Builder $query, int $year) {
                $query->having('year', $year);
            })
            ->when($month, function (Builder $query, int $month) {
                $query->having('month', $month);
            })
            ->get();
    }
}