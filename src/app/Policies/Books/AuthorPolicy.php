<?php

namespace App\Policies\Books;

use App\Models\V1\Books\Author;
use App\Models\V1\User;
use Illuminate\Auth\Access\Response;

class AuthorPolicy
{
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() || $user->isEditor() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Author $author): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Author $author): bool
    {
        return false;
    }

    public function delete(User $user, Author $author): bool
    {
        return false;
    }

    public function restore(User $user, Author $author): bool
    {
        return false;
    }

    public function forceDelete(User $user, Author $author): bool
    {
        return false;
    }
}
