<?php

namespace App\Listeners\Books;

use App\Events\Orders\OrderReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class IncreaseBooksSellingCount
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderReceived $event): void
    {
        DB::transaction(function () use ($event) {
            $event->order->books()
                ->without('likedByUsers')
                ->without('paperFormat')
                ->without('electronicFormat')
                ->without('audioFormat')
                ->get()
                ->each(fn ($book) => $book->update(['selling_count' => $book->selling_count + 1]));
        });
    }
}
