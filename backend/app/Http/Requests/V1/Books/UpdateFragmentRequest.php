<?php

namespace App\Http\Requests\V1\Books;

class UpdateFragmentRequest extends FragmentRequest
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
            'url' => ['required', 'url', 'max:255'],
            'book_id' => ['required', 'exists:books,id'],
        ];
    }

    protected function patchRules(): array
    {
        return [
            'url' => ['url', 'max:255'],
            'book_id' => ['exists:books,id'],
        ];
    }
}    
