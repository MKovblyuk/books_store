<?php

namespace App\Actions\Orders;

use App\Enums\OrderStatus;
use App\Models\V1\Books\Category;
use App\Models\V1\Orders\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;

class GetCategoriesStatAction
{
    /**
     * Returns statistics on the number of books sold
     * grouped by years, months and categories
     * and sorted by number of books sold.
     * The number of books sold is calculated for the category and its children
     */
    public function execute(int $year = null, int $month = null): Collection
    {
        return Order::query()
            ->join('book_order', 'orders.id', '=', 'book_order.order_id')
            ->join('books', 'book_order.book_id', '=', 'books.id')
            ->join('categories', function (JoinClause $join) {
                $join->whereBetweenColumns('books.category_id', ['categories._lft', 'categories._rgt']);
                $join->whereNotNull('categories.parent_id');
            })
            ->selectRaw(implode(',',[
                'categories.id as category_id', 
                'categories.name as category_name', 
                'YEAR(orders.created_at) as year', 
                'MONTH(orders.created_at) as month', 
                'SUM(book_order.quantity) as books_sold_count'
            ]))
            ->where('orders.status', OrderStatus::Received)
            ->groupBy('year', 'month', 'categories.id')
            ->when($year, function (Builder $query, int $year) {
                $query->having('year', $year);
            })
            ->when($month, function (Builder $query, int $month) {
                $query->having('month', $month);
            })
            ->orderBy('books_sold_count', 'desc')
            ->get();
    }
}