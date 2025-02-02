<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Actions\Addresses\GetDeliveryPlacesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreDeliveryPlaceRequest;
use App\Http\Requests\V1\Addresses\UpdateDeliveryPlaceRequest;
use App\Http\Resources\V1\Addresses\DeliveryPlaceCollection;
use App\Http\Resources\V1\Addresses\DeliveryPlaceResource;
use App\Http\Resources\V1\Addresses\FullAddressResource;
use App\Models\V1\Addresses\DeliveryPlace;

class DeliveryPlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index','show', 'getFullAddress']]);
    }

    public function index(GetDeliveryPlacesAction $action)
    {
        return new DeliveryPlaceCollection($action->execute(request('per_page', 15)));
    }

    public function store(StoreDeliveryPlaceRequest $request)
    {
        $this->authorize('create', DeliveryPlace::class);
        DeliveryPlace::create($request->validated());

        return response()->json(['message' => 'Delivery place successfully created'], 201);
    }

    public function show(DeliveryPlace $deliveryPlace)
    {
        return new DeliveryPlaceResource($deliveryPlace);
    }

    public function update(UpdateDeliveryPlaceRequest $request, DeliveryPlace $deliveryPlace)
    {
        $this->authorize('update', $deliveryPlace);
        $deliveryPlace->update($request->validated());

        return response()->json(['message' => 'Delivery place successfully updated'], 200);
    }

    public function destroy(DeliveryPlace $deliveryPlace)
    {
        $this->authorize('delete', $deliveryPlace);
        
        return $deliveryPlace->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Settlement not deleted'], 400);
    }

    public function getFullAddress(DeliveryPlace $deliveryPlace)
    {
        return new FullAddressResource($deliveryPlace);
    }
}
