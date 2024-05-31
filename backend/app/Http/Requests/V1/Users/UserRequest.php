<?php

namespace App\Http\Requests\V1\Users;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        if (isset($this->firstName)) {
            $this->merge(['first_name' => $this->firstName]);
        }
        if (isset($this->lastName)) {
            $this->merge(['last_name' => $this->lastName]);
        }
        if (isset($this->phoneNumber)) {
            $this->merge(['phone_number' => $this->phoneNumber]);
        }
        if (isset($this->passwordConfirmation)) {
            $this->merge(['password_confirmation' => $this->passwordConfirmation]);
        }
    }
}
