<?php

namespace App\Policies\Books;

use App\Models\V1\Books\Publisher;
use App\Models\V1\User;
use Illuminate\Auth\Access\Response;

class PublisherPolicy
{
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() || $user->isEditor() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Publisher $publisher): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Publisher $publisher): bool
    {
        return false;
    }

    public function delete(User $user, Publisher $publisher): bool
    {
        return false;
    }

    public function restore(User $user, Publisher $publisher): bool
    {
        return false;
    }

    public function forceDelete(User $user, Publisher $publisher): bool
    {
        return false;
    }
}
