<?php

namespace App\Http\Requests\V1\Books;

use App\Rules\BookFormats;

class StoreBookRequest extends BookRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:75'],
            'description' => ['required', 'string', 'min:10', 'max:1200'],
            'publication_year' => ['required', 'integer', 'min:0', 'max:' . now()->year],
            'language' => ['required', 'string', 'max:50'],
            'cover_image_url' => ['sometimes', 'nullable', 'url'],
            'publisher_id' => ['required', 'exists:publishers,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'published_at' => ['sometimes', 'nullable', 'date'],
            'formats' => ['required','array', 'max:3', new BookFormats()],
            'authors_ids' => ['required', 'array'],
            'authors_ids.*' => ['required', 'integer', 'exists:authors,id'],
        ];
    }
}
