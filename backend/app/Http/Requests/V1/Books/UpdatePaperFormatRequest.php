<?php

namespace App\Http\Requests\V1\Books;

use App\Rules\Books\PaperFormat;

class UpdatePaperFormatRequest extends PaperFormatRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return request()->method() === 'PUT' 
            ? (new PaperFormat())->postRules()
            : (new PaperFormat())->patchRules();
    }
}
