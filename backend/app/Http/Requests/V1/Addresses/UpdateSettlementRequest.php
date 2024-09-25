<?php

namespace App\Http\Requests\V1\Addresses;

class UpdateSettlementRequest extends SettlementRequest
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
            'name' => ['max:255', 'unique:settlements,name'],
            'district_id' => ['exists:districts,id'],
        ];
    }

    protected function patchRules(): array
    {
        return [
            'name' => ['required', 'max:255', 'unique:settlements,name'],
            'district_id' => ['required', 'exists:districts,id'],
        ];
    }
}
