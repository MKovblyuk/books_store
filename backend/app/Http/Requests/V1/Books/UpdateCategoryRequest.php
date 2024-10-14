<?php

namespace App\Http\Requests\V1\Books;

class UpdateCategoryRequest extends CategoryRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->method() == 'PUT' ? $this->putRules() : $this->patchRules();
    }

    protected function putRules(): array
    {
        return [
            'name' => ['required', 'max:100'],
        ];
    }

    protected function patchRules(): array
    {
        return [
            'name' => ['max:100'],
        ];
    }
}
