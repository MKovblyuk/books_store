<?php

namespace App\Actions\Users;

use App\Models\V1\Books\Book;
use App\Models\V1\User;

class LikeBookAction
{
    public function execute(User $user, Book $book)
    {
        $user->likedBooks()->attach($book->id);
    }
}