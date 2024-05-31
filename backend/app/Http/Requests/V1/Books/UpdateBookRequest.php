<?php

namespace App\Http\Requests\V1\Books;

use App\Rules\BookFormats;

class UpdateBookRequest extends BookRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->method() === 'PUT' ? $this->putRules() : $this->patchRules();
    }

    public function putRules(): array
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
            'authors_ids.*' => ['required','integer', 'exists:authors,id'],
        ];
    }

    public function patchRules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:75'],
            'description' => ['sometimes', 'string', 'min:10', 'max:1200'],
            'publication_year' => ['sometimes', 'integer', 'min:0', 'max:' . now()->year],
            'language' => ['sometimes', 'string', 'max:50'],
            'cover_image_url' => ['sometimes', 'nullable', 'url'],
            'publisher_id' => ['sometimes', 'exists:publishers,id'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'published_at' => ['sometimes', 'nullable', 'date'],
            'formats' => ['sometimes','array', 'max:3', new BookFormats()],
            'authors_ids' => ['sometimes', 'array'],
            'authors_ids.*' => ['sometimes','integer', 'exists:authors,id'],
        ];
    }
}
