<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Actions\Orders\GetBookFormatsStatAction;
use App\Actions\Orders\GetCategoriesStatAction;
use App\Actions\Orders\GetOrdersAction;
use App\Actions\Orders\GetOrdersCreationInfoAction;
use App\Actions\Orders\UpdateOrderAction;
use App\Exceptions\General\IncorrectDataException;
use App\Exceptions\Orders\IncorrectPaymentMethodException;
use App\Http\Controllers\Controller;
use App\Http\Middleware\GuestUserHandling;
use App\Http\Requests\V1\Orders\StoreOrderRequest;
use App\Http\Requests\V1\Orders\UpdateOrderRequest;
use App\Http\Resources\V1\Orders\OrderCollection;
use App\Http\Resources\V1\Orders\OrderDetailCollection;
use App\Http\Resources\V1\Orders\OrderResource;
use App\Http\Resources\V1\Orders\OrdersCreationInfoCollection;
use App\Http\Transformers\BookFormatsStatTransformer;
use App\Http\Transformers\CategoriesStatTransformer;
use App\Models\V1\Orders\Order;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['confirmOnlinePaymentOrder', 'store', 'createOnlinePaymentOrder']]);
        $this->middleware(GuestUserHandling::class)->only(['store', 'createOnlinePaymentOrder']);
    }

    public function index(GetOrdersAction $action)
    {
        $this->authorize('viewAny', Order::class);
        return new OrderCollection($action->execute(request('per_page', 10)));
    }

    public function store(StoreOrderRequest $request, OrderService $service)
    {
        try {
            $this->authorize('create', Order::class);

            return $service->createUponReceivingOrder($request->validated())
                ? response()->json(['message' => 'Order successfully created'], 201)
                : response()->json(['message' => 'Order not created'], 400);
        } catch (IncorrectPaymentMethodException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (IncorrectDataException $e) {
            return response()->json(['message' => 'The number of available books has been exceeded'], 422);
        }
    }

    public function createOnlinePaymentOrder(StoreOrderRequest $request, OrderService $service)
    {
        try {
            $this->authorize('create', Order::class);
            return $service->createOnlinePaymentOrder($request->validated());
        } catch (IncorrectPaymentMethodException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (IncorrectDataException $e) {
            return response()->json(['message' => 'The number of available books has been exceeded'], 422);
        }
    }

    public function confirmOnlinePaymentOrder(Request $request, OrderService $service)
    {
        $service->confirmOnlinePaymentOrder($request->all());
        return response('');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return new OrderResource($order);
    }

    public function showDetails(Order $order)
    {
        $this->authorize('showDetails', $order);
        return new OrderDetailCollection($order->details());
    }

    public function update(UpdateOrderRequest $request, Order $order, UpdateOrderAction $action)
    {
        $this->authorize('update', $order);

        return $action->execute($order, $request->validated())
            ? response()->json(['message' => 'Order successfully updated'], 200)
            : response()->json(['message' => 'Order not updated'], 400);
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        return $order->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Order not deleted']);
    }

    public function getCreationInfo(GetOrdersCreationInfoAction $action)
    {
        $this->authorize('showStatistic', Order::class);
        return new OrdersCreationInfoCollection($action->execute());
    }

    public function getCategoriesStat(GetCategoriesStatAction $action, CategoriesStatTransformer $transformer)
    {
        $this->authorize('showStatistic', Order::class);
        $data = $transformer->transform($action->execute(request('year'), request('month')));
        return response()->json(['data' => $data]);
    }

    public function getBookFormatsStat(GetBookFormatsStatAction $action, BookFormatsStatTransformer $transformer)
    {
        $this->authorize('showStatistic', Order::class);
        $data = $transformer->transform($action->execute(request('year'), request('month')));
        return response()->json(['data' => $data]);
    }
}
