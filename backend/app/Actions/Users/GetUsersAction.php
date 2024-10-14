<?php

namespace App\Actions\Users;

use App\Models\V1\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetUsersAction
{
    public function execute()
    {
        return QueryBuilder::for(User::class)
            ->allowedFields([
                'id', 
                'first_name', 
                'last_name', 
                'email', 
                'role', 
                'phone_number',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'), 
                'first_name', 
                'last_name', 
                'email', 
                'role', 
                'phone_number',
            ])
            ->allowedSorts([
                'id', 
                'first_name', 
                'last_name', 
                'email', 
                'phone_number',
            ])
            ->allowedIncludes([
                'orders', 
                'reviews', 
                'likedBooks',
            ])
            ->get();
    }
}