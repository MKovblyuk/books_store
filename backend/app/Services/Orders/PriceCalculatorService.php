<?php

namespace App\Services\Orders;

use App\Enums\BookFormat;
use App\Models\V1\Books\Book;

class PriceCalculatorService implements PriceCalculatorInterface
{
    public function calculate(array $data): float
    {
        $details = $data['details'];
        $price = 0;

        for ($i = 0; $i < count($details); $i++) {
            $book = Book::find($details[$i]['book_id']);
            $price += $book->getPrice(BookFormat::from($details[$i]['book_format'])) * $details[$i]['quantity'];
        }

        return $price;
    }
}