<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreCountryRequest;
use App\Http\Requests\V1\Addresses\StoreRegionRequest;
use App\Http\Requests\V1\Addresses\UpdateRegionRequest;
use App\Http\Resources\V1\Addresses\RegionCollection;
use App\Http\Resources\V1\Addresses\RegionResource;
use App\Models\V1\Addresses\Region;
use Exception;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class RegionController extends Controller
{
    public function index()
    {
        $regions = QueryBuilder::for(Region::class)
            ->allowedFields('id', 'name', 'country_id')
            ->allowedFilters('id', 'name', 'country_id')
            ->allowedSorts('id', 'name', 'country_id')
            ->allowedIncludes('country')
            ->get();

        return new RegionCollection($regions);
    }

    public function store(StoreRegionRequest $request)
    {
        Region::create($request->validated());
        return response()->json(['message' => 'Region successfully created'], 201);
    }

    public function show(Region $region)
    {
        return new RegionResource($region);
    }

    public function update(UpdateRegionRequest $request, Region $region)
    {
        $region->update($request->validated());
        return response()->json(['message' => 'Region seccessfully updated'], 200);
    }

    public function destroy(Region $region)
    {
        return $region->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Region not deleted'], 400);
    }
}
