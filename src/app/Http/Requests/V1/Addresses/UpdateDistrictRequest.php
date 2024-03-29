<?php

namespace App\Http\Requests\V1\Addresses;

class UpdateDistrictRequest extends DistrictRequest
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
            'name' => ['required', 'max:255'],
            'region_id' => ['required', 'exists:regions,id']
        ];
    }

    protected function patchRules(): array
    {
        return [
            'name' => ['max:255'],
            'region_id' => ['exists:regions,id'],
        ];
    }
}
