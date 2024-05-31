<?php

namespace Database\Seeders\Books;

use App\Models\V1\Books\Book;
use App\Models\V1\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikedBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all()->random(3);
        
        $users->each( function (User $user) {
            $book_1 = Book::all()->random();
            $user->likeBook($book_1);
            $user->likeBook(Book::all()->diff(collect([$book_1]))->random());
        });
    }


}
