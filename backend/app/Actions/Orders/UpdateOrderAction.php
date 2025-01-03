<?php

namespace App\Actions\Orders;

use App\Enums\OrderStatus;
use App\Events\Orders\OrderReceived;
use App\Models\V1\Orders\Order;

class UpdateOrderAction
{
    public function execute(Order $order, array $attributes): bool
    {
        $oldStatus = $order->status;
        $res = $order->update($attributes);

        isset($attributes['status']) 
            && OrderStatus::from($attributes['status']) === OrderStatus::Received 
            && $oldStatus !== OrderStatus::Received
            && OrderReceived::dispatch($order);

        return $res;
    }
}