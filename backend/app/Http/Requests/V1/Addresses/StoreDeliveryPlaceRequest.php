<?php

namespace App\Http\Requests\V1\Addresses;

class StoreDeliveryPlaceRequest extends DeliveryPlaceRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'street_address' => ['required', 'max:255'],
            'settlement_id' => ['required', 'exists:settlements,id'],
            'shipping_method_id' => ['required', 'exists:shipping_methods,id'],
        ];
    }
}
