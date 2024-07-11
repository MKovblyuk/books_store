<?php

namespace App\Policies\Users;

use App\Models\V1\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        
        return false;
    }

    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    public function getOrders(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    public function getElectronicBooks(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    public function getAudioBooks(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    public function getLikedBooks(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}
