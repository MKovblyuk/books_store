<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreDistrictRequest;
use App\Http\Requests\V1\Addresses\UpdateDistrictRequest;
use App\Http\Resources\V1\Addresses\DistrictCollection;
use App\Http\Resources\V1\Addresses\DistrictResource;
use App\Models\V1\Addresses\District;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = QueryBuilder::for(District::class)
            ->allowedFields('id', 'name', 'district_id')
            ->allowedFilters('id', 'name', 'district_id')
            ->allowedSorts('id', 'name', 'district_id')
            ->allowedIncludes('region')
            ->get();

        return new DistrictCollection($districts);
    }

    public function store(StoreDistrictRequest $request)
    {
        District::create($request->validated());
        return response(['message' => 'District successfully create'], 201);
    }

    public function show(District $district)
    {
        return new DistrictResource($district);
    }

    public function update(UpdateDistrictRequest $request, District $district)
    {
        $district->update($request->validated());
        return response(['message' => 'District successfully updated'], 200);
    }

    public function destroy(District $district)
    {
        return $district->delete()
            ? response()->noContent()
            : response()->json(['message' => 'District not deleted'], 400);
    }
}
