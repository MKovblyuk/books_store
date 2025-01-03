<?php

namespace App\Actions\Users;

use App\Models\V1\User;
use Illuminate\Database\Eloquent\Collection;

class GetUsersRegistrationInfoAction
{
    public function execute(): Collection
    {
        return User::query()
            ->selectRaw('count(id) as users_count, DATE(created_at) as creation_date')
            ->groupBy('creation_date')
            ->get();
    }
}