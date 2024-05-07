<?php

namespace App\Http\Requests\V1\Books;

class StoreAuthorRequest extends AuthorRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'description' => ['required', 'max:1000'],
            'photo_url' => ['max:255'],
        ];
    }
}
