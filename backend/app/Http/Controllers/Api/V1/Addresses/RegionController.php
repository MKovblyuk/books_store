<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Actions\Addresses\GetRegionsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreRegionRequest;
use App\Http\Requests\V1\Addresses\UpdateRegionRequest;
use App\Http\Resources\V1\Addresses\RegionCollection;
use App\Http\Resources\V1\Addresses\RegionResource;
use App\Models\V1\Addresses\Region;
use Illuminate\Auth\Access\AuthorizationException;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(GetRegionsAction $action)
    {
        return new RegionCollection($action->execute());
    }

    public function store(StoreRegionRequest $request)
    {
        try {
            $this->authorize('create', Region::class);
            Region::create($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'Region successfully created'], 201);
    }

    public function show(Region $region)
    {
        return new RegionResource($region);
    }

    public function update(UpdateRegionRequest $request, Region $region)
    {
        try {
            $this->authorize('update', $region);
            $region->update($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'Region seccessfully updated'], 200);
    }

    public function destroy(Region $region)
    {
        try {
            $this->authorize('delete', $region);

            return $region->delete()
                ? response()->noContent()
                : response()->json(['message' => 'Region not deleted'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
