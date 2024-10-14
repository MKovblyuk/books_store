<?php

namespace App\Http\Requests\V1\Books;

class StoreCategoryRequest extends CategoryRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:100'],
            'children' => ['array'],
        ];
    }
}
