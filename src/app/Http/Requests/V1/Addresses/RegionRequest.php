<?php

namespace App\Http\Requests\V1\Addresses;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegionRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        if (isset($this->countryId)) {
            $this->merge(['country_id' => $this->countryId]);
        }
    }
}
