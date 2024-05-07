<?php

namespace App\Http\Requests\V1\Addresses;

class UpdateCountryRequest extends CountryRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->method() == 'PUT' ? $this->putRules() : $this->patchRules();
    }

    protected function patchRules(): array
    {
        return [
            'name' => ['max:255', 'unique:countries']
        ];
    }

    protected function putRules(): array
    {
        return [
            'name' => ['required', 'max:255', 'unique:countries']
        ];
    }
}
