<?php

namespace App\Http\Requests\V1\Users;

use App\Enums\UserRole;
use App\Rules\PhoneNumber;
use Illuminate\Validation\Rule;

class StoreUserRequest extends UserRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:75'],
            'last_name' => ['required', 'max:75'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['sometimes', Rule::enum(UserRole::class)],
            'phone_number' => ['required', 'max:30', 'unique:users,phone_number', new PhoneNumber()],
            'password' => ['required', 'max:15', 'min:6', 'confirmed'],
            'password_confirmation' => ['required']
        ];
    }
}
