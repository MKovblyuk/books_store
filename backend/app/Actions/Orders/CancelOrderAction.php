<?php

namespace App\Actions\Orders;

use App\Enums\BookFormat;
use App\Models\V1\Books\PaperFormat;
use App\Models\V1\Orders\Order;
use Illuminate\Support\Facades\DB;

class CancelOrderAction
{
    private const DEADLOCK_ATTEMPTS = 10;

    public function execute(Order $order) 
    {
        DB::transaction(function () use ($order) {

            foreach ($order->details() as $orderDetail) {
                if (BookFormat::from($orderDetail['book_format']) === BookFormat::Paper) {
                    PaperFormat::lockForUpdate()
                        ->where('book_id', $orderDetail['book_id'])
                        ->first()
                        ->increaseQuantity($orderDetail['quantity']);
                }
            }

            $order->delete();

        }, self::DEADLOCK_ATTEMPTS);
    }
}