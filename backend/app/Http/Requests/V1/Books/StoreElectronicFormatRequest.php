<?php

namespace App\Http\Requests\V1\Books;

use App\Rules\Books\ElectronicFormat;

class StoreElectronicFormatRequest extends ElectronicFormatRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return (new ElectronicFormat())->postRules();
    }
}
