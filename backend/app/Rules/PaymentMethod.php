<?php

namespace App\Rules;

use App\Enums\BookFormat;
use App\Enums\PaymentMethods;
use App\Models\V1\Orders\PaymentMethod as OrdersPaymentMethod;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PaymentMethod implements ValidationRule
{
    public function __construct(
        private array $booksDetails
    )
    {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (OrdersPaymentMethod::find($value)->method === PaymentMethods::UponReceiving) {
            foreach($this->booksDetails as $bookDetail) {
                if (BookFormat::from($bookDetail['book_format']) !== BookFormat::Paper) {
                    $fail('Payment method not compatible with book format. Upon receiving orders only support books with paper format');
                }
            }
        }
    }
}