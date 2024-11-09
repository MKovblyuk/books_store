<?php

namespace App\Http\Resources\V1\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersRegistrationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'usersCount' => $this->users_count,
            'creationDate' => $this->creation_date,
        ];
    }
}
