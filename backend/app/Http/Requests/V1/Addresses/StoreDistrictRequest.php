<?php

namespace App\Http\Requests\V1\Addresses;

class StoreDistrictRequest extends DistrictRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'region_id' => ['required', 'exists:regions,id'],
        ];
    }
}
