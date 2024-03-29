<?php

namespace App\Interfaces\Repositories;

use App\Models\V1\Books\Book;

interface BookRepositoryInterface {
    public function getAll();
    public function store(array $attributes): bool;
    public function update(Book $book, array $attributes): bool;
    public function destroy(Book $book): bool;
}