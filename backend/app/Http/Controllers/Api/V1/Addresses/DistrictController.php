<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreDistrictRequest;
use App\Http\Requests\V1\Addresses\UpdateDistrictRequest;
use App\Http\Resources\V1\Addresses\DistrictCollection;
use App\Http\Resources\V1\Addresses\DistrictResource;
use App\Models\V1\Addresses\District;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\QueryBuilder\QueryBuilder;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

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
        try {
            $this->authorize('create', District::class);
            District::create($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response(['message' => 'District successfully create'], 201);
    }

    public function show(District $district)
    {
        return new DistrictResource($district);
    }

    public function update(UpdateDistrictRequest $request, District $district)
    {
        try {
            $this->authorize('update', $district);
            $district->update($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response(['message' => 'District successfully updated'], 200);
    }

    public function destroy(District $district)
    {
        $this->authorize('delete', $district);

        return $district->delete()
            ? response()->noContent()
            : response()->json(['message' => 'District not deleted'], 400);
    }
}