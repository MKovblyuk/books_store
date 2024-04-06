<?php

namespace App\Policies\Addresses;

use App\Models\V1\Addresses\District;
use App\Models\V1\User;
use Illuminate\Auth\Access\Response;

class DistrictPolicy
{
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() || $user->isEditor() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, District $district): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, District $district): bool
    {
        return false;
    }

    public function delete(User $user, District $district): bool
    {
        return false;
    }

    public function restore(User $user, District $district): bool
    {
        return false;
    }

    public function forceDelete(User $user, District $district): bool
    {
        return false;
    }
}
