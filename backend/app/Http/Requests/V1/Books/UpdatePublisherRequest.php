<?php

namespace App\Http\Requests\V1\Books;

class UpdatePublisherRequest extends PublisherRequest
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
            'name' => ['required', 'unique:publishers', 'max:255'],
        ];
    }

    protected function patchRules(): array
    {
        return [
            'name' => ['sometimes', 'unique:publishers', 'max:255'],
        ];
    }
}
