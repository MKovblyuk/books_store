<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Actions\Addresses\GetSettlementsWithPaginateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreSettlementRequest;
use App\Http\Requests\V1\Addresses\UpdateSettlementRequest;
use App\Http\Resources\V1\Addresses\SettlementCollection;
use App\Http\Resources\V1\Addresses\SettlementResource;
use App\Models\V1\Addresses\Settlement;

class SettlementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(GetSettlementsWithPaginateAction $action)
    {
        return new SettlementCollection($action->execute(request('per_page', 15)));
    }

    public function store(StoreSettlementRequest $request)
    {
        $this->authorize('create', Settlement::class);
        Settlement::create($request->validated());

        return response()->json(['message' => 'Settlement successfully created'], 201);
    }

    public function show(Settlement $settlement)
    {
        return new SettlementResource($settlement);
    }

    public function update(UpdateSettlementRequest $request, Settlement $settlement)
    {
        $this->authorize('update', $settlement);
        $settlement->update($request->validated());

        return response()->json(['message' => 'Settlement successfully updated'], 200);
    }

    public function destroy(Settlement $settlement)
    {
        $this->authorize('delete', $settlement);
        
        return $settlement->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Settlement not deleted'], 400);
    }
}
