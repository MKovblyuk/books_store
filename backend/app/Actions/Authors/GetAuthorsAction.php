<?php

namespace App\Actions\Authors;

use App\Models\V1\Books\Author;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetAuthorsAction
{
    public function execute(int $perPage = null)
    {
        $query = QueryBuilder::for(Author::class)
            ->allowedFilters([
                AllowedFilter::exact('id'), 
                'first_name', 
                'last_name',
            ])
            ->allowedFields([
                'id', 
                'first_name', 
                'last_name', 
                'description', 
            ])
            ->allowedSorts([
                'id', 
                'first_name', 
                'last_name',
            ]);

        return $perPage ? $query->paginate($perPage) : $query->get();
    }
}