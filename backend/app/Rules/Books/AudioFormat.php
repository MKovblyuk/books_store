<?php

namespace App\Rules\Books;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class AudioFormat implements ValidationRule
{
    public function __construct(
        private string $method
    )
    {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rules = strtoupper($this->method)=== 'PATCH' ? $this->patchRules() : $this->postRules();
        $validator = Validator::make($value, $rules);

        if ($validator->fails()) {
            $fail('Audio Format ' .$validator->errors()->all()[0]);
        }
    }

    public function postRules(): array
    {
        return [
            'price' => ['required', 'decimal:0,2', 'min:0'],
            'discount' => ['sometimes', 'decimal:0,2', 'min:0'],
            'duration' => ['required', 'integer', 'min:0'],
            'files' => ['required', 'array'],
            'files.*' => [File::types(['mp3'])->max('250mb')],
        ];
    }

    public function patchRules(): array
    {
        return [
            'price' => ['sometimes', 'decimal:0,2', 'min:0'],
            'discount' => ['sometimes', 'decimal:0,2', 'min:0'],
            'duration' => ['sometimes', 'integer', 'min:0'],
            'files' => ['sometimes', 'array'],
            'files.*' => [File::types(['mp3'])->max('250mb')],
        ];
    }
}