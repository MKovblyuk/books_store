<?php

namespace App\Policies\Addresses;

use App\Models\V1\Addresses\Address;
use App\Models\V1\User;
use Illuminate\Auth\Access\Response;

class AddressPolicy
{
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() || $user->isEditor() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Address $address): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Address $address): bool
    {
        return false;
    }

    public function delete(User $user, Address $address): bool
    {
        return false;
    }

    public function restore(User $user, Address $address): bool
    {
        return false;
    }

    public function forceDelete(User $user, Address $address): bool
    {
        return false;
    }
}
