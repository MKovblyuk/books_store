<?php

namespace App\Http\Requests\V1\Books;

use Illuminate\Validation\Rules\File;

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
            'book_id' => ['required', 'exists:books,id'],
            'file' => ['required', File::types(['jpg', 'png', 'jpeg'])],
        ];
    }

    protected function patchRules(): array
    {
        return [
            'book_id' => ['exists:books,id'],
            'file' => [File::types(['jpg', 'png', 'jpeg'])],
        ];
    }
}    
