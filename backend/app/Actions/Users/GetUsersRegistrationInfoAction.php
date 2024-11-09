<?php

namespace App\Actions\Users;

use App\Models\V1\User;
use Illuminate\Database\Eloquent\Collection;

class GetUsersRegistrationInfoAction
{
    public function execute(): Collection
    {
        return User::query()
            ->selectRaw('count(id) as users_count, created_at')
            ->groupBy('created_at')
            ->get();
    }
}