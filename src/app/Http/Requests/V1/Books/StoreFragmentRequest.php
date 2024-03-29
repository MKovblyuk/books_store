<?php

namespace App\Http\Requests\V1\Books;

class StoreFragmentRequest extends FragmentRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => ['required', 'url', 'max:255'],
            'book_id' => ['required', 'exists:books,id'],
        ];
    }
}
