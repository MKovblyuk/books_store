<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreCountryRequest;
use App\Http\Requests\V1\Addresses\UpdateCountryRequest;
use App\Http\Resources\V1\Addresses\CountryCollection;
use App\Http\Resources\V1\Addresses\CountryResource;
use App\Models\V1\Addresses\Country;
use Spatie\QueryBuilder\QueryBuilder;

class CountryController extends Controller
{
    public function index()
    {
        $countries = QueryBuilder::for(Country::class)
            ->allowedFields('id', 'name')
            ->allowedFilters('id', 'name')
            ->allowedSorts('id', 'name')
            ->allowedIncludes('id', 'name')
            ->get();
        
        return new CountryCollection($countries);
    }

    public function store(StoreCountryRequest $request)
    {
        Country::create($request->validated());
        return response()->json(['message' => 'Country successfully created'], 201);
    }

    public function show(Country $country)
    {
        return new CountryResource($country);
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country->update($request->validated());
        return response()->json(['message' => 'Country successfully updated'], 200);
    }

    public function destroy(Country $country)
    {
        return $country->delete() 
            ? response()->noContent()
            : response()->json(['message' => 'Author not deleted'], 400);

    }
}
