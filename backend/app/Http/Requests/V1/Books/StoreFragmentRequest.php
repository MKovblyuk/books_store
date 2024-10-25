<?php

namespace App\Http\Requests\V1\Books;

use Illuminate\Validation\Rules\File;

class StoreFragmentRequest extends FragmentRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => ['required', 'exists:books,id'],
            'file' => ['required', File::types(['jpg', 'png', 'jpeg'])->max('10mb')],
        ];
    }
}
