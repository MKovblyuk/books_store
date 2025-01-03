<?php

namespace App\Actions\Users;

use App\Filters\DateFilter;
use App\Models\V1\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetUsersAction
{
    public function execute(int $perPage)
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
                AllowedFilter::custom('created_at', new DateFilter()),
                AllowedFilter::custom('updated_at', new DateFilter()),
            ])
            ->allowedSorts([
                'id', 
                'first_name', 
                'last_name', 
                'email', 
                'phone_number',
                'created_at',
                'updated_at',
            ])
            ->allowedIncludes([
                'orders', 
                'reviews', 
                'likedBooks',
            ])
            ->paginate($perPage);
    }
}