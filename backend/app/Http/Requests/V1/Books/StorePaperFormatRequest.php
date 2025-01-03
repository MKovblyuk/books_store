<?php

namespace App\Http\Requests\V1\Books;

use App\Rules\Books\PaperFormat;

class StorePaperFormatRequest extends PaperFormatRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return (new PaperFormat())->postRules();
    }
}
