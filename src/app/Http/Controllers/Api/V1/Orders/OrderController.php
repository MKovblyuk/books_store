<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Orders\StoreOrderRequest;
use App\Http\Requests\V1\Orders\UpdateOrderRequest;
use App\Http\Resources\V1\Orders\OrderCollection;
use App\Http\Resources\V1\Orders\OrderDetailCollection;
use App\Http\Resources\V1\Orders\OrderResource;
use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Models\V1\Orders\Order;

class OrderController extends Controller
{
    public function __construct(
        private OrderRepositoryInterface $repository
    )
    {
    }

    public function index()
    {
        return new OrderCollection($this->repository->getAll());
    }

    public function store(StoreOrderRequest $request)
    {
        return $this->repository->store($request->validated())
            ? response()->json(['message' => 'Order successfully created'], 201)
            : response()->json(['message' => 'Order not created'], 400);;
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function showDetails(Order $order)
    {
        return new OrderDetailCollection($order->details());
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        return $this->repository->update($order, $request->validated())
            ? response()->json(['message' => 'Order successfully updated'], 200)
            : response()->json(['message' => 'Order not updated'], 400);
    }

    public function destroy(Order $order)
    {
        return $this->repository->destroy($order)
            ? response()->noContent()
            : response()->json(['message' => 'Order not deleted']);
    }
}
