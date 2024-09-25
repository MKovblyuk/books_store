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
            'user_id' => ['required', 'exists:users,id'],
            'delivery_place_id' => ['required', 'exists:delivery_places,id'],
            'status' => ['required', Rule::enum(OrderStatus::class)],
        ];
    }

    public function patchRules(): array
    {
        return [
            'user_id' => ['sometimes', 'exists:users,id'],
            'delivery_place_id' => ['exists:delivery_places,id'],
            'status' => ['sometimes', Rule::enum(OrderStatus::class)],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        if (isset($this->userId)) {
            $this->merge(['user_id' => $this->userId]);
        }
        if (isset($this->deliveryPlaceId)) {
            $this->merge(['delivery_place_id' => $this->deliveryPlaceId]);
        }
    }
}
