<?php

namespace Database\Seeders\Orders;

use App\Enums\BookFormat;
use App\Models\Books\Book;
use App\Models\Books\PaperFormat;
use App\Models\Orders\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $books = Book::all()->random(3);

        Order::factory(10)
            ->hasAttached(
                $books,
                [
                    'quantity' => 1,
                    'total_price' => rand(100,300),
                    'book_type' => BookFormat::Paper->name,
                ]
            )
            ->create();
    }


}
