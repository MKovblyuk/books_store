<?php

namespace App\Rules\Books;

use App\Enums\BookFormat as EnumsBookFormat;
use App\Factories\BookFormatValidationRuleFactory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BookFormat implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $formatName = ucfirst(explode(".", $attribute)[1]);
        $bookFormat = EnumsBookFormat::tryFrom($formatName);

        if (!$bookFormat) {
            $fail('Incorrect format name: ' . $formatName);
        }

        BookFormatValidationRuleFactory::create($bookFormat)->validate($formatName, $value, $fail);
    }
}