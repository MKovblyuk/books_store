<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Actions\Orders\GetAllOrdersWithPaginateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Orders\StoreOrderRequest;
use App\Http\Requests\V1\Orders\UpdateOrderRequest;
use App\Http\Resources\V1\Orders\OrderCollection;
use App\Http\Resources\V1\Orders\OrderDetailCollection;
use App\Http\Resources\V1\Orders\OrderResource;
use App\Models\V1\Orders\Order;
use App\Services\Orders\OrderService;
use Illuminate\Auth\Access\AuthorizationException;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(GetAllOrdersWithPaginateAction $action)
    {
        try {
            $this->authorize('viewAny', Order::class);
            return new OrderCollection($action->execute(request()->get('per_page', 10)));
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $this->authorize('create', Order::class);

            return OrderService::store($request->validated())
                ? response()->json(['message' => 'Order successfully created'], 201)
                : response()->json(['message' => 'Order not created'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function show(Order $order)
    {
        try {
            $this->authorize('view', $order);
            return new OrderResource($order);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function showDetails(Order $order)
    {
        try {
            $this->authorize('showDetails', $order);
            return new OrderDetailCollection($order->details());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            $this->authorize('update', $order);

            return OrderService::update($request->validated(), $order)
                ? response()->json(['message' => 'Order successfully updated'], 200)
                : response()->json(['message' => 'Order not updated'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function destroy(Order $order)
    {
        try {
            $this->authorize('delete', $order);

            return $order->delete()
                ? response()->noContent()
                : response()->json(['message' => 'Order not deleted']);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
