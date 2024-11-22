<?php

namespace App\Rules\Books;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class PaperFormat implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {        
        $validator = Validator::make($value, [
            'price' => ['required', 'decimal:0,2', 'min:0'],
            'discount' => ['sometimes', 'decimal:0,2', 'min:0'],
            'quantity' => ['sometimes', 'integer', 'min:0'],
            'page_count' => ['required', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            $fail('Paper Format ' . $validator->errors()->all()[0]);
        }
    }
}