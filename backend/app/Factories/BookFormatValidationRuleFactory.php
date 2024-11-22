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
    public static function create(BookFormat $format): ValidationRule
    {
        switch ($format) {
            case BookFormat::Audio : return new AudioFormat;
            case BookFormat::Electronic : return new ElectronicFormat;
            case BookFormat::Paper : return new PaperFormat;
            default: throw new Exception('Not found passed book format');
        }
    }
}