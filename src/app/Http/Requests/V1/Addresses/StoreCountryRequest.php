<?php

namespace App\Http\Requests\V1\Addresses;

class StoreCountryRequest extends CountryRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'unique:countries']
        ];
    }
}
