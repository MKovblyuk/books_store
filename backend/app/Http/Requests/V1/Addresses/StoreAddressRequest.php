<?php

namespace App\Http\Requests\V1\Addresses;

class StoreAddressRequest extends AddressRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'settlement_name' => ['required', 'max:255'],
            'street_name' => ['nullable','max:255'],
            'street_number' => ['nullable', 'max:255'],
            'postal_code' => ['required', 'max:255'],
            'district_id' => ['required', 'exists:districts,id'],
        ];
    }

}
