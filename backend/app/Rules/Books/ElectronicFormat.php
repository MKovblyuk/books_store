<?php

namespace App\Rules\Books;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class ElectronicFormat implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validator = Validator::make($value, [
            'price' => ['required', 'decimal:0,2', 'min:0'],
            'discount' => ['sometimes', 'decimal:0,2', 'min:0'],
            'page_count' => ['required', 'integer', 'min:1'],
            'files' => ['required', 'array'],
            'files.*' => [File::types(['pdf'])->max('250mb')],
        ]);

        if ($validator->fails()) {
            $fail('Electronic Format ' .$validator->errors()->all()[0]);
        }
    }
}