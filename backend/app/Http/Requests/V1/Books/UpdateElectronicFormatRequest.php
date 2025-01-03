<?php

namespace App\Http\Requests\V1\Books;

use App\Rules\Books\ElectronicFormat;

class UpdateElectronicFormatRequest extends ElectronicFormatRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return strtoupper($this->_method) === 'PUT' 
            ? (new ElectronicFormat())->postRules() 
            : (new ElectronicFormat())->patchRules();
    }
}
