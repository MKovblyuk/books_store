<?php

namespace App\Actions\Addresses;

use App\Models\V1\Addresses\Country;
use Spatie\QueryBuilder\QueryBuilder;

class GetCountriesAction
{
    public function execute(int $perPage = null)
    {
        $query = QueryBuilder::for(Country::class)
            ->allowedFields('id', 'name')
            ->allowedFilters('id', 'name')
            ->allowedSorts('id', 'name')
            ->allowedIncludes('id', 'name');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }
}