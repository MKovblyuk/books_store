<?php

namespace App\Http\Requests\V1\Addresses;

class UpdateRegionRequest extends RegionRequest
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
            'name' => ['max:255', 'unique:regions'],
            'country_id' => ['exists:countries,id'],
        ];
    }

    protected function putRules(): array
    {
        return [
            'name' => ['required', 'max:255', 'unique:regions'],
            'country_id' => ['required', 'exists:countries,id'],
        ];
    }
}
