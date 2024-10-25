<?php

namespace App\Http\Requests\V1\Books;

class UpdateAuthorRequest extends AuthorRequest
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
            'first_name' => ['max:50'],
            'last_name' => ['max:50'],
            'description' => ['max:1000'],
        ];
    }

    protected function putRules(): array
    {
        return [
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'description' => ['required', 'max:1000'],
        ];
    }
}
