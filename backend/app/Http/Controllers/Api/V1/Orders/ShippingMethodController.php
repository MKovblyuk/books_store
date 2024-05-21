<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Orders\StoreShippingMethodRequest;
use App\Http\Requests\V1\Orders\UpdateShippingMethodRequest;
use App\Http\Resources\V1\Orders\ShippingMethodCollection;
use App\Http\Resources\V1\Orders\ShippingMethodResource;
use App\Models\V1\Orders\ShippingMethod;
use Illuminate\Auth\Access\AuthorizationException;

class ShippingMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return new ShippingMethodCollection(ShippingMethod::all());
    }

    public function store(StoreShippingMethodRequest $request)
    {
        try {
            $this->authorize('create', ShippingMethod::class);
            ShippingMethod::create($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'Shipping method successfully created'], 201);
    }

    public function show(ShippingMethod $shippingMethod)
    {
        return new ShippingMethodResource($shippingMethod);
    }

    public function update(UpdateShippingMethodRequest $request, ShippingMethod $shippingMethod)
    {
        try {
            $this->authorize('update', $shippingMethod);
            $shippingMethod->update($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'Shipping method successfully updated'], 200);
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        try {
            $this->authorize('delete', $shippingMethod);

            return $shippingMethod->delete()
                ? response()->noContent()
                : response()->json(['message' => 'Shipping method not deleted'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
