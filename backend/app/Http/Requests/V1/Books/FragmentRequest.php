<?php

namespace App\Http\Requests\V1\Books;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class FragmentRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (isset($this->bookId)) {
            $this->merge(['book_id' => $this->bookId]);
        }
    }    

    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }
}
