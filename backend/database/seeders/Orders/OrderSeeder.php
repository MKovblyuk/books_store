<?php

namespace Database\Seeders\Orders;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Models\V1\Addresses\DeliveryPlace;
use App\Models\V1\Books\Book;
use App\Models\V1\Orders\Order;
use App\Models\V1\Orders\PaymentMethod;
use App\Models\V1\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public const ORDERS_COUNT = 100;
    public const ATTACHED_BOOKS_COUNT = 3;

    public function run(): void
    {
        DB::transaction(function () {
            $order = Order::factory(self::ORDERS_COUNT)
                ->for(User::inRandomOrder()->first())
                ->for(DeliveryPlace::inRandomOrder()->first())
                ->for(PaymentMethod::where('method', PaymentMethods::CreditCard)->first())
                ->afterCreating(fn(Order $order) => $this->attachBooks($order))
                ->create([
                    'total_price' => rand(100, 2000),
                    'status' => OrderStatus::Received
                ]);
        });
    }

    private function attachBooks(Order $order): void
    {
        foreach (Book::inRandomOrder()->take(self::ATTACHED_BOOKS_COUNT)->get() as $book) {
            $order->books()->attach($book->id, [
                'quantity' => 1,
                'book_format' => $book->availableFormats()->random()
            ]);
        }
    }
}
