<?php

namespace App\Http\Requests\V1\Books;

use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePublisherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->method() == 'PUT' ? $this->putRules() : $this->patchRules();
    }

    protected function putRules(): array
    {
        return [
            'name' => ['required', 'unique:publishers', 'max:255'],
        ];
    }

    protected function patchRules(): array
    {
        return [
            'name' => ['sometimes', 'unique:publishers', 'max:255'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }
}