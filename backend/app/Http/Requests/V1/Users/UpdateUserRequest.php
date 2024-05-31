<?php

namespace App\Http\Requests\V1\Users;

use App\Enums\UserRole;
use App\Rules\PhoneNumber;
use App\Rules\UniqueExceptCurrent;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends UserRequest
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
            'first_name' => ['required', 'max:75'],
            'last_name' => ['required', 'max:75'],
            'email' => ['required', 'email', new UniqueExceptCurrent('users', 'email', $this->user->email)],
            'role' => ['required', Rule::enum(UserRole::class)],
            'phone_number' => ['required', new PhoneNumber()],
            'password' => ['required', 'max:15', 'min:6', 'confirmed'],
            'password_confirmation' => ['required']
        ];
    }

    protected function patchRules(): array
    {
        return [
            'first_name' => ['max:75'],
            'last_name' => ['max:75'],
            'email' => ['email', new UniqueExceptCurrent('users', 'email', $this->user->email)],
            'role' => [Rule::enum(UserRole::class)],
            'phone_number' => ['sometimes', new PhoneNumber()],
            'password' => ['max:15', 'min:6', 'confirmed'],
            'password_confirmation' => ['sometimes']
        ];
    }
}
