<?php

namespace App\Http\Requests\V1\Books;

class UpdateReviewRequest extends ReviewRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->method() === 'PUT' ? $this->putRules() : $this->patchRules();
    }

    protected function putRules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'max:255'],
        ];
    }

    protected function patchRules(): array
    {
        return [
            'rating' => ['integer', 'min:1', 'max:5'],
            'review' => ['max:255'],
        ];
    }
}
