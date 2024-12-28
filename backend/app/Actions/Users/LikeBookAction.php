<?php

namespace App\Actions\Users;

use App\Models\V1\Books\Book;
use App\Models\V1\User;
use Illuminate\Support\Facades\DB;

class LikeBookAction
{
    public function execute(User $user, Book $book)
    {
        DB::transaction(function () use($user, $book) {
            $user->likedBooks()->attach($book->id);
            $book->update(['likes' => $book->likes + 1]);
        });
    }
}