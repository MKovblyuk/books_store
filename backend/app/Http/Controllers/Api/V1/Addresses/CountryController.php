<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreCountryRequest;
use App\Http\Requests\V1\Addresses\UpdateCountryRequest;
use App\Http\Resources\V1\Addresses\CountryCollection;
use App\Http\Resources\V1\Addresses\CountryResource;
use App\Models\V1\Addresses\Country;
use http\Env\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\QueryBuilder\QueryBuilder;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

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
        try {
            $this->authorize('create', Country::class);
            Country::create($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'Country successfully created'], 201);
    }

    public function show(Country $country)
    {
        return new CountryResource($country);
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        try {
            $this->authorize('update', $country);
            $country->update($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'Country successfully updated'], 200);
    }

    public function destroy(Country $country)
    {
        try {
            $this->authorize('delete', $country);

            return $country->delete()
                ? response()->noContent()
                : response()->json(['message' => 'Author not deleted'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
