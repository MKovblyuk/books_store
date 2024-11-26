<?php

namespace App\Factories;

use App\Enums\BookFormat;
use App\Rules\Books\AudioFormat;
use App\Rules\Books\ElectronicFormat;
use App\Rules\Books\PaperFormat;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;

class BookFormatValidationRuleFactory
{
    public static function create(BookFormat $format, string $method): ValidationRule
    {
        switch ($format) {
            case BookFormat::Audio : return new AudioFormat($method);
            case BookFormat::Electronic : return new ElectronicFormat($method);
            case BookFormat::Paper : return new PaperFormat($method);
            default: throw new Exception('Not found passed book format');
        }
    }
}