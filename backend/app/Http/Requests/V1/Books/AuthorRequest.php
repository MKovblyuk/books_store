<?php

namespace App\Http\Requests\V1\Books;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AuthorRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (isset($this->firstName)) {
            $this->merge(['first_name' => $this->firstName]);
        }
        if (isset($this->lastName)) {
            $this->merge(['last_name' => $this->lastName]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }
}
