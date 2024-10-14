<?php

namespace App\Http\Requests\V1\Books;

class StorePublisherRequest extends PublisherRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:publishers', 'max:255'],
        ];
    }
}
