<?php

namespace App\Http\Requests\V1\Books;

use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PaperFormatRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (isset($this->pageCount)) {
            $this->merge(['page_count' => $this->pageCount]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }
}
