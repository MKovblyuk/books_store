<?php

namespace App\Actions\Users;

use App\Models\V1\Books\Book;
use App\Models\V1\User;

class UnlikeBookAction
{
    public function execute(User $user, Book $book)
    {
        $user->likedBooks()->detach($book->id);
    }
}