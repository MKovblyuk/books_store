<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreSettlementRequest;
use App\Http\Requests\V1\Addresses\UpdateSettlementRequest;
use App\Http\Resources\V1\Addresses\SettlementCollection;
use App\Http\Resources\V1\Addresses\SettlementResource;
use App\Models\V1\Addresses\Settlement;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SettlementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $settlements = QueryBuilder::for(Settlement::class)
            ->allowedFields(['id', 'name', 'district_id'])
            ->allowedFilters([
                AllowedFilter::exact('id'), 
                AllowedFilter::exact('district_id'),
                'name'
            ])
            ->allowedSorts(['id', 'name', 'district_id'])
            ->allowedIncludes('district')
            ->paginate(request('per_page'));

        return new SettlementCollection($settlements);
    }

    public function store(StoreSettlementRequest $request)
    {
        try {
            $this->authorize('create', Settlement::class);
            Settlement::create($request->validated());
            return response()->json(['message' => 'Settlement successfully created'], 201);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function show(Settlement $settlement)
    {
        return new SettlementResource($settlement);
    }

    public function update(UpdateSettlementRequest $request, Settlement $settlement)
    {
        try {
            $this->authorize('update', $settlement);
            $settlement->update($request->validated());
            return response()->json(['message' => 'Settlement successfully updated'], 200);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function destroy(Settlement $settlement)
    {
        try {
            $this->authorize('delete', $settlement);
            return $settlement->delete()
                ? response()->noContent()
                : response()->json(['message' => 'Settlement not deleted'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
