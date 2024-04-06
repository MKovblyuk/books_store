<?php

namespace App\Repositories\V1;

use App\Enums\BookFormat;
use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Models\V1\Books\Book;
use App\Models\V1\Orders\Order;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderRepository implements OrderRepositoryInterface 
{
    public function getAll()
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

    public function store(array $attributes): bool
    {
        $this->addTotalPriceField($attributes['details']);

        DB::transaction(function () use($attributes){
            $order = Order::create($attributes);

            foreach ($attributes['details'] as $detail) {
                $order->books()->attach($detail['book_id'], $detail);

                if ($detail['book_format'] === BookFormat::Paper->value) {
                    Book::find($detail['book_id'])->paperFormat->decreaseQuantity($detail['quantity']);
                }
            } 
        });

        // create event order created

        return true;
    }


    private function addTotalPriceField(&$details): void
    {
        for ($i = 0; $i < count($details); $i++) {
            $book = Book::find($details[$i]['book_id']);
            $total_price = $book->getPrice(BookFormat::from($details[$i]['book_format']), $details[$i]['quantity']);
            $details[$i]['total_price'] = $total_price;
        }
    }

    public function update(Order $order, array $attributes): bool
    {
        $order->update($attributes);

        // create event

        return true;        
    }

    public function destroy(Order $order): bool
    {
        $order->delete();
        
        // create event

        return true;
    }
}