<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class BookFormats implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (isset($value['paper'])) {
            $this->validatePaperFormat($value['paper'], $fail);
        }
        if (isset($value['audio'])) {
            $this->validateAudioFormat($value['audio'], $fail);
        }
        if (isset($value['electronic'])) {
            $this->validateElectronicFormat($value['electronic'], $fail);
        }

    }

    private function validatePaperFormat(mixed $format, Closure $fail): void
    {
        $validator = Validator::make($format, [
            'price' => ['required', 'decimal:0,2', 'min:0'],
            'discount' => ['sometimes', 'decimal:0,2', 'min:0'],
            'quantity' => ['sometimes', 'integer', 'min:0'],
            'page_count' => ['required', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            $fail('Paper Format ' . $validator->errors()->all()[0]);
        }
    }

    private function validateElectronicFormat(mixed $format, Closure $fail): void
    {
        $validator = Validator::make($format, [
            'price' => ['required', 'decimal:0,2', 'min:0'],
            'discount' => ['sometimes', 'decimal:0,2', 'min:0'],
            'page_count' => ['required', 'integer', 'min:1'],
            'url' => ['required', 'url'],
        ]);

        if ($validator->fails()) {
            $fail('Electronic Format ' .$validator->errors()->all()[0]);
        }
    }

    private function validateAudioFormat(mixed $format, Closure $fail): void
    {
        $validator = Validator::make($format, [
            'price' => ['required', 'decimal:0,2', 'min:0'],
            'discount' => ['sometimes', 'decimal:0,2', 'min:0'],
            'duration' => ['required', 'integer', 'min:0'],
            'url' => ['required', 'url'],
        ]);

        if ($validator->fails()) {
            $fail('Audio Format ' .$validator->errors()->all()[0]);
        }
    }
}
