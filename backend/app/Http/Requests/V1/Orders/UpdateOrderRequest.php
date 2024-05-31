<?php

namespace App\Http\Requests\V1\Orders;

use App\Enums\OrderStatus;
use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->method() === 'PUT' ? $this->putRules() : $this->patchRules();
    }

    public function putRules(): array
    {
        return [
            'address_id' => ['required', 'exists:addresses,id'],
            'user_id' => ['required', 'exists:users,id'],
            'shipping_method_id' => ['required', 'exists:shipping_methods,id'],
            'status' => ['required', Rule::enum(OrderStatus::class)],
        ];
    }

    public function patchRules(): array
    {
        return [
            'address_id' => ['sometimes', 'exists:addresses,id'],
            'user_id' => ['sometimes', 'exists:users,id'],
            'shipping_method_id' => ['sometimes', 'exists:shipping_methods,id'],
            'status' => ['sometimes', Rule::enum(OrderStatus::class)],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        if (isset($this->addressId)) {
            $this->merge(['address_id' => $this->addressId ]);
        }

        if (isset($this->userId)) {
            $this->merge(['user_id' => $this->userId]);
        }
        
        if (isset($this->shippingMethodId)) {
            $this->merge(['shipping_method_id' => $this->shippingMethodId]);
        }
    }
}
