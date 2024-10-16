<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Actions\Addresses\GetDistrictsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreDistrictRequest;
use App\Http\Requests\V1\Addresses\UpdateDistrictRequest;
use App\Http\Resources\V1\Addresses\DistrictCollection;
use App\Http\Resources\V1\Addresses\DistrictResource;
use App\Models\V1\Addresses\District;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(GetDistrictsAction $action)
    {
        return new DistrictCollection($action->execute());
    }

    public function store(StoreDistrictRequest $request)
    {
        $this->authorize('create', District::class);
        District::create($request->validated());

        return response(['message' => 'District successfully create'], 201);
    }

    public function show(District $district)
    {
        return new DistrictResource($district);
    }

    public function update(UpdateDistrictRequest $request, District $district)
    {
        $this->authorize('update', $district);
        $district->update($request->validated());

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
