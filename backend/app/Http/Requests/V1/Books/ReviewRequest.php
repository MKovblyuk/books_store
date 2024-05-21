<?php

namespace App\Http\Requests\V1\Books;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ReviewRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_id' => request()->user()->id]);

        if (isset($this->bookId)) {
            $this->merge(['book_id' => $this->bookId]);
        }
    }
}
