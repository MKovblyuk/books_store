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
    public const ORDERS_COUNT = 10;

    public function run(): void
    {
        DB::transaction(function () {
            for ($i = 0; $i < self::ORDERS_COUNT; $i++) {    
                $order = Order::factory()
                    ->for(User::all()->random())
                    ->for(DeliveryPlace::all()->random())
                    ->for(PaymentMethod::where('name', PaymentMethods::CreditCard->name)->first())
                    ->create([
                        'total_price' => rand(100, 2000),
                        'status' => OrderStatus::Received
                    ]);
                    
                foreach (Book::all()->random(3) as $book) {
                    $order->books()->attach($book->id, [
                        'quantity' => 1,
                        'book_format' => $book->availableFormats()->random()
                    ]);
                }
            }
        });
    }
}
