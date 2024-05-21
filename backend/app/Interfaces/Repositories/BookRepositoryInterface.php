<?php

namespace App\Interfaces\Repositories;

use App\Models\V1\Books\Book;

interface BookRepositoryInterface {
    public function getAll();
}
