<?php

namespace App\Policies\Books;

use App\Models\V1\Books\Fragment;
use App\Models\V1\User;
use Illuminate\Auth\Access\Response;

class FragmentPolicy
{
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() || $user->isEditor() ? true : null;
    }

     public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Fragment $fragment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Fragment $fragment): bool
    {
        return false;
    }

    public function delete(User $user, Fragment $fragment): bool
    {
        return false;
    }

    public function restore(User $user, Fragment $fragment): bool
    {
        return false;
    }

    public function forceDelete(User $user, Fragment $fragment): bool
    {
        return false;
    }
}
