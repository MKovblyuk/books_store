<?php

namespace App\Rules\Books;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class PaperFormat implements ValidationRule
{
    public function __construct(
        private string $method = 'POST'
    )
    {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {        
        $rules = strtoupper($this->method) === 'PATCH' ? $this->patchRules() : $this->postRules();
        $validator = Validator::make($value, $rules);

        if ($validator->fails()) {
            $fail('Paper Format ' . $validator->errors()->all()[0]);
        }
    }

    public function postRules(): array
    {
        return [
            'price' => ['required', 'decimal:0,2', 'min:0'],
            'discount' => ['sometimes', 'decimal:0,2', 'min:0', 'max:100'],
            'quantity' => ['required', 'integer', 'min:0'],
            'page_count' => ['required', 'integer', 'min:1'],
        ];
    }

    public function patchRules(): array
    {
        return [
            'price' => ['sometimes', 'decimal:0,2', 'min:0'],
            'discount' => ['sometimes', 'decimal:0,2', 'min:0', 'max:100'],
            'quantity' => ['sometimes', 'integer', 'min:0'],
            'page_count' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}