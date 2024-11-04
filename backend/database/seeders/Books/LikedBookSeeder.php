<?php

namespace Database\Seeders\Books;

use App\Actions\Users\LikeBookAction;
use App\Models\V1\Books\Book;
use App\Models\V1\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikedBookSeeder extends Seeder
{
    public function __construct(
        private LikeBookAction $likeBookAction
    )
    {}

    public function run(): void
    {
        $users = User::all()->random(3);
        
        $users->each( function (User $user) {
            $book1 = Book::all()->random();
            $this->likeBookAction->execute($user, $book1);
            $this->likeBookAction->execute($user, Book::all()->diff(collect([$book1]))->random());
        });
    }


}
