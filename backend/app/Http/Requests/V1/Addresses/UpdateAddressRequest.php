<?php

namespace App\Http\Requests\V1\Addresses;

class UpdateAddressRequest extends AddressRequest
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
            'settlement_name' => ['required', 'max:255'],
            'street_name' => ['present','nullable','max:255'],
            'street_number' => ['present','nullable', 'max:255'],
            'postal_code' => ['required', 'max:255'],
            'district_id' => ['required', 'exists:districts,id'],
        ];
    }

    protected function patchRules(): array
    {
        return [
            'settlement_name' => ['max:255'],
            'street_name' => ['nullable','max:255'],
            'street_number' => ['nullable', 'max:255'],
            'postal_code' => ['max:255'],
            'district_id' => ['exists:districts,id'],
        ];
    }
}
