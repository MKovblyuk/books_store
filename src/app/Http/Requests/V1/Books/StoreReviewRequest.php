<?php

namespace App\Http\Requests\V1\Books;

class StoreReviewRequest extends ReviewRequest
{
    public function authorize(): bool
    {
        return request()->user() !== null;
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
        ];
    }
}
