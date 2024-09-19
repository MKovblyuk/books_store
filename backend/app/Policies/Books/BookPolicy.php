<?php

namespace App\Policies\Books;

use App\Enums\BookFormat;
use App\Models\V1\Books\Book;
use App\Models\V1\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() || $user->isEditor() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Book $book): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Book $book): bool
    {
        return false;
    }

    public function delete(User $user, Book $book): bool
    {
        return false;
    }

    public function restore(User $user, Book $book): bool
    {
        return false;
    }

    public function forceDelete(User $user, Book $book): bool
    {
        return false;
    }

    public function deleteFormat(User $user, Book $book): bool
    {
        return false;
    }

    public function downloadElectronicBook(User $user, Book $book): bool
    {
        return Book::withFormatForUser(BookFormat::Electronic, $user)->get()->contains($book);
    }

    public function downloadAudioBook(User $user, Book $book): bool
    {
        return Book::withFormatForUser(BookFormat::Audio, $user)->get()->contains($book);
    }

    public function uploadFiles(): bool
    {
        return false;
    }
}
