<?php

namespace App\Http\Requests\V1\Addresses;

class StoreSettlementRequest extends SettlementRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'unique:settlements,name'],
            'district_id' => ['required', 'exists:districts,id'],
        ];
    }
}
