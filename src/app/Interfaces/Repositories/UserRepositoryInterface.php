<?php

namespace App\Interfaces\Repositories;

use App\Models\V1\User;

interface UserRepositoryInterface {
    public function getAll();
    public function getById(User $user);
    public function store(array $attributes);
    public function update(User $user, array $attributes);
    public function destroy(User $user);
}