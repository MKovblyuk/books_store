<?php

namespace App\Actions\Users;

use App\Models\V1\Books\Book;
use App\Models\V1\User;
use Illuminate\Support\Facades\DB;

class UnlikeBookAction
{
    public function execute(User $user, Book $book)
    {
        DB::transaction(function () use($user, $book) {
            if ($user->likedBooks()->detach($book->id) && $book->likes > 0) {
                $book->update(['likes' => $book->likes - 1]);
            }
        });
    }
}