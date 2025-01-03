<?php

namespace App\Actions\Orders;

use App\Enums\OrderStatus;
use App\Models\V1\Orders\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GetBookFormatsStatAction
{
    /**
    * Returns statistics on the number of books sold
    * grouped by years, months and book formats
    * and sorted by number of books sold
    */
    public function execute(int $year = null, int $month = null): Collection
    {
        $res = Order::query()
            ->join('book_order', 'orders.id', '=', 'book_order.order_id')
            ->selectRaw(implode(',', [
                'book_order.book_format',
                'YEAR(orders.created_at) as year',
                'MONTH(orders.created_at) as month',
                'SUM(book_order.quantity) as books_sold_count'
            ]))
            ->where('orders.status', OrderStatus::Received)
            ->groupBy('year', 'month', 'book_order.book_format')
            ->when($year, function (Builder $query, int $year) {
                $query->having('year', $year);
            })
            ->when($month, function (Builder $query, int $month) {
                $query->having('month', $month);
            })
            ->orderBy('books_sold_count', 'desc')
            ->get();

        return $res;
    }   
}