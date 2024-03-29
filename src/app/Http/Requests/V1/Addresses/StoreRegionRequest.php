<?php

namespace App\Http\Requests\V1\Addresses;

class StoreRegionRequest extends RegionRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'unique:regions'],
            'country_id' => ['required', 'exists:countries,id'],
        ];
    }
}
