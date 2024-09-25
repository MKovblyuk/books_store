<?php

namespace App\Http\Requests\V1\Addresses;

class UpdateDeliveryPlaceRequest extends DeliveryPlaceRequest
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
            'street_address' => ['max:255'],
            'settlement_id' => ['exists:settlements,id'],
            'shipping_method_id' => ['exists:shipping_methods,id'],
        ];
    }

    protected function patchRules(): array
    {
        return [
            'street_address' => ['required', 'max:255'],
            'settlement_id' => ['required', 'exists:settlements,id'],
            'shipping_method_id' => ['required', 'exists:shipping_methods,id'],
        ];
    }
}
