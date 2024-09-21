<?php

namespace App\Services\Orders;

use App\Enums\BookFormat;
use App\Models\V1\Books\Book;

class PriceCalculatorService implements PriceCalculatorInterface
{
    public function calculate(array $data): float
    {
        $details = $data['details'];
        $totalPrice = 0;

        for ($i = 0; $i < count($details); $i++) {
            $book = Book::find($details[$i]['book_id']);
            $format = BookFormat::from($details[$i]['book_format']);

            $price = $book->getPrice($format);
            $discount = $book->getDiscount($format);
     
            $totalPrice += ($price - ($price * $discount / 100)) * $details[$i]['quantity'];
        }

        return $totalPrice;
    }
}