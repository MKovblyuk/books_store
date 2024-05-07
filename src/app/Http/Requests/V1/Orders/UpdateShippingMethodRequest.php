<?php

namespace App\Http\Requests\V1\Orders;

use App\Enums\ShippingMethods;
use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShippingMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->method() === 'PUT' ? $this->putRules() : $this->patchRules();
    }

    protected function putRules(): array
    {
        return [
            'name' => ['required', 'max:255', Rule::enum(ShippingMethods::class)]
        ];
    }

    protected function patchRules(): array
    {
        return [
            'name' => ['max:255', Rule::enum(ShippingMethods::class)]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }
}
