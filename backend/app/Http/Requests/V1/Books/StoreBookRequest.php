<?php

namespace App\Http\Requests\V1\Books;

use App\Rules\Books\BookFormat;
use Illuminate\Validation\Rules\File;

class StoreBookRequest extends FormDataBookRequest
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
}
