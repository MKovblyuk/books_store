<?php

namespace App\Jobs;

use App\Actions\Orders\CancelOrderAction;
use App\Enums\OrderStatus;
use App\Models\V1\Orders\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class ProcessPendingOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Order $order
    )
    {
        $this->onConnection('database')->onQueue('processingPendingOrders');
    }

    public function handle(CancelOrderAction $action): void
    {
        if ($this->order->status === OrderStatus::Pending) {
            $action->execute($this->order);
        }
    }

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->order->id)];
    }
}
