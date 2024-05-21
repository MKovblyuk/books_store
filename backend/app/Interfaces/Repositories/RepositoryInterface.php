<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface
{
    public function getAll(): Collection;
}
