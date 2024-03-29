<?php

namespace App\Rules;

use App\Enums\BookFormat;
use App\Models\V1\Books\Book;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderDatails implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validator = Validator::make($value, [
            '*.book_format' => ['required', Rule::enum(BookFormat::class)],
            '*.quantity' => ['required', 'integer', 'min:1'],
            '*.book_id' => ['required', 'exists:books,id'],
        ]);

        if ($validator->fails()) {
            $fail($validator->errors()->all()[0]);
            return;
        }

        foreach ($validator->validated() as $data) {
            if (!$this->formatAvailable($data['book_format'], $data['book_id'])) {
                $fail('The ' . $data['book_format'] . ' it is more than count of book with id: ' . $data['book_id']);
            }
            if (!$this->quantityAvailable($data)) {
                $fail('The ' . $data['quantity'] . ' books not availble for book with id: ' . $data['book_id']);
            }
        }
    }

    private function formatAvailable(string $format, $bookId): bool
    {
        return Book::find($bookId)->hasFormat(BookFormat::from($format));
    }

    private function quantityAvailable(array $data): bool
    {
        return BookFormat::Paper === BookFormat::from($data['book_format'])
            ? Book::find($data['book_id'])->paperFormat->quantity >= $data['quantity']
            : $data['quantity'] > 0;
    }
}
