<?php

namespace App\Http\Requests\V1\Addresses;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AddressRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        if (isset($this->settlementName)) {
            $this->merge(['settlement_name' => $this->settlementName]);
        }
        if (isset($this->streetName)) {
            $this->merge(['street_name' => $this->streetName]);
        }
        if (isset($this->streetNumber)) {
            $this->merge(['street_number' => $this->streetNumber]);
        }
        if (isset($this->postalCode)) {
            $this->merge(['postal_code' => $this->postalCode]);
        }
        if (isset($this->districtId)) {
            $this->merge(['district_id' => $this->districtId]);
        }
    }
}
