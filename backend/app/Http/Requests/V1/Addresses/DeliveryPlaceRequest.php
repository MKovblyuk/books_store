<?php

namespace App\Http\Requests\V1\Addresses;

use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DeliveryPlaceRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        if (isset($this->settlementId)) {
            $this->merge(['settlement_id' => $this->settlementId]);
        }
        if (isset($this->streetAddress)) {
            $this->merge(['street_address' => $this->streetAddress]);
        }
        if (isset($this->shippingMethodId)) {
            $this->merge(['shipping_method_id' => $this->shippingMethodId]);
        }
    }
}
