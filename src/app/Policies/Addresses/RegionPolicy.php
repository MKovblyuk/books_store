<?php

namespace App\Policies\Addresses;

use App\Models\V1\Addresses\Region;
use App\Models\V1\User;
use Illuminate\Auth\Access\Response;

class RegionPolicy
{
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() || $user->isEditor() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Region $region): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Region $region): bool
    {
        return false;
    }

    public function delete(User $user, Region $region): bool
    {
        return false;
    }

    public function restore(User $user, Region $region): bool
    {
        return false;
    }

    public function forceDelete(User $user, Region $region): bool
    {
        return false;
    }
}
