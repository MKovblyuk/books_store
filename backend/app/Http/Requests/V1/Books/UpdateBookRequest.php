<?php

namespace App\Http\Requests\V1\Books;

use App\Rules\Books\BookFormat;
use Illuminate\Validation\Rules\File;

class UpdateBookRequest extends FormDataBookRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return strtoupper($this->_method) === 'PUT' ? $this->putRules() : $this->patchRules();
    }

    public function putRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:75'],
            'description' => ['required', 'string', 'min:10', 'max:1200'],
            'publication_year' => ['required', 'integer', 'min:0', 'max:' . now()->year],
            'language' => ['required', 'string', 'max:50'],
            'publisher_id' => ['required', 'exists:publishers,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'published_at' => ['sometimes', 'nullable', 'date'],
            'formats' => ['required', 'array'],
            'formats.*' => [new BookFormat],
            'authors_ids' => ['required', 'array'],
            'authors_ids.*' => ['required', 'integer', 'exists:authors,id'],
            'cover_image' => ['sometimes', File::types(['jpg', 'png', 'jpeg'])->max('20mb')],
        ];
    }

    public function patchRules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:75'],
            'description' => ['sometimes', 'string', 'min:10', 'max:1200'],
            'publication_year' => ['sometimes', 'integer', 'min:0', 'max:' . now()->year],
            'language' => ['sometimes', 'string', 'max:50'],
            'publisher_id' => ['sometimes', 'exists:publishers,id'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'published_at' => ['sometimes', 'nullable', 'date'],
            'formats' => ['sometimes', 'array'],
            'formats.*' => [new BookFormat('PATCH')],
            'authors_ids' => ['sometimes', 'array'],
            'authors_ids.*' => ['sometimes', 'integer', 'exists:authors,id'],
            'cover_image' => ['sometimes', File::types(['jpg', 'png', 'jpeg'])->max('20mb')],
        ];
    }
}
