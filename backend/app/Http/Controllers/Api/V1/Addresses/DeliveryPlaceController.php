<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Actions\Addresses\GetDeliveryPlacesWithPaginateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreDeliveryPlaceRequest;
use App\Http\Requests\V1\Addresses\UpdateDeliveryPlaceRequest;
use App\Http\Resources\V1\Addresses\DeliveryPlaceCollection;
use App\Http\Resources\V1\Addresses\DeliveryPlaceResource;
use App\Models\V1\Addresses\DeliveryPlace;
use Illuminate\Auth\Access\AuthorizationException;

class DeliveryPlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index','show']]);
    }

    public function index(GetDeliveryPlacesWithPaginateAction $action)
    {
        return new DeliveryPlaceCollection($action->execute(request('per_page', 15)));
    }

    public function store(StoreDeliveryPlaceRequest $request)
    {
        try {
            $this->authorize('create', DeliveryPlace::class);
            DeliveryPlace::create($request->validated());
            return response()->json(['message' => 'Delivery place successfully created'], 201);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403); 
        }
    }

    public function show(DeliveryPlace $deliveryPlace)
    {
        return new DeliveryPlaceResource($deliveryPlace);
    }

    public function update(UpdateDeliveryPlaceRequest $request, DeliveryPlace $deliveryPlace)
    {
        try {
            $this->authorize('update', $deliveryPlace);
            $deliveryPlace->update($request->validated());
            return response()->json(['message' => 'Delivery place successfully updated'], 200);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403); 
        } 
    }

    public function destroy(DeliveryPlace $deliveryPlace)
    {
        try {
            $this->authorize('delete', $deliveryPlace);
            return $deliveryPlace->delete()
                ? response()->noContent()
                : response()->json(['message' => 'Settlement not deleted'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403); 
        } 
    }
}
