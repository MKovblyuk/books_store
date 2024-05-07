<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isPhoneNumber($value)) {
            $fail('The :attribute not correct phone number');
        }
    }

    private function isPhoneNumber($value): bool
    {
        // todo

        return true;
    }
}
