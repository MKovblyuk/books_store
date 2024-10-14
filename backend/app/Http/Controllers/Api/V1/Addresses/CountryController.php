<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Actions\Addresses\GetCountriesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreCountryRequest;
use App\Http\Requests\V1\Addresses\UpdateCountryRequest;
use App\Http\Resources\V1\Addresses\CountryCollection;
use App\Http\Resources\V1\Addresses\CountryResource;
use App\Models\V1\Addresses\Country;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(GetCountriesAction $action)
    {
        return new CountryCollection($action->execute());
    }

    public function store(StoreCountryRequest $request)
    {
        $this->authorize('create', Country::class);
        Country::create($request->validated());

        return response()->json(['message' => 'Country successfully created'], 201);
    }

    public function show(Country $country)
    {
        return new CountryResource($country);
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $this->authorize('update', $country);
        $country->update($request->validated());

        return response()->json(['message' => 'Country successfully updated'], 200);
    }

    public function destroy(Country $country)
    {
        $this->authorize('delete', $country);

        return $country->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Author not deleted'], 400);
    }
}
