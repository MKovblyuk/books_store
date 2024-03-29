<?php

namespace App\Http\Requests\V1\Addresses;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class DistrictRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        if (isset($this->regionId)) {
            $this->merge(['region_id' => $this->regionId]);
        }
    }
}
