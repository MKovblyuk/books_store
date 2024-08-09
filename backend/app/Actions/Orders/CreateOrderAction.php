<?php

namespace App\Actions\Orders;

use App\Enums\BookFormat;
use App\Enums\ShippingMethods;
use App\Models\V1\Books\Book;
use App\Models\V1\Orders\Order;
use App\Models\V1\Orders\ShippingMethod;
use Illuminate\Support\Facades\DB;

class CreateOrderAction 
{
    public function execute(array $attributes): bool
    {
        dd($attributes);

        $this->calculateTotalPriceField($attributes['details']);

        $shippingMethod = ShippingMethod::find($attributes['shipping_method_id']);

        if ($shippingMethod->name === ShippingMethods::UponReceiving) {
            // TODO call and change order status
        }

        if ($shippingMethod->name === ShippingMethods::GooglePay) {
            // TODO payment transaction
        }


        DB::transaction(function () use($attributes){

            $order = Order::create($attributes);

            foreach ($attributes['details'] as $detail) {
                $order->books()->attach($detail['book_id'], $detail);

                if ($detail['book_format'] === BookFormat::Paper->value) {
                    Book::find($detail['book_id'])->paperFormat->decreaseQuantity($detail['quantity']);
                }
            }
        });

        return true;
    }

    private function calculateTotalPriceField(&$details): void
    {
        for ($i = 0; $i < count($details); $i++) {
            $book = Book::find($details[$i]['book_id']);
            $total_price = $book->getPrice(BookFormat::from($details[$i]['book_format']), $details[$i]['quantity']);
            $details[$i]['total_price'] = $total_price;
        }
    }
}