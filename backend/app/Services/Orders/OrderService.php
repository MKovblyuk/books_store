<?php

namespace App\Services\Orders;

use App\Enums\BookFormat;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Events\Orders\OrderReadyToSend;
use App\Events\Orders\UponReceivingOrderCreated;
use App\Exceptions\Orders\IncorrectPaymentMethodException;
use App\Models\V1\Books\Book;
use App\Models\V1\Orders\Order;
use App\Models\V1\Orders\PaymentMethod;
use Illuminate\Support\Facades\DB;

class OrderService
{
    private PaymentServiceInterface $paymentService;
    private PriceCalculatorService $priceCalculator;

    public function __construct(PaymentServiceInterface $paymentService, PriceCalculatorInterface $priceCalculator)
    {
        $this->paymentService = $paymentService;
        $this->priceCalculator = $priceCalculator;
    }

    public function createUponReceivingOrder(array $attributes): bool
    {
        $attributes['total_price'] = $this->priceCalculator->calculate($attributes);
        $paymentMethod = PaymentMethod::find($attributes['payment_method_id'])->method;

        if ($paymentMethod !== PaymentMethods::UponReceiving) {
            throw new IncorrectPaymentMethodException('Incorrect payment method');
        }

        DB::transaction(function () use($attributes){
            $order = $this->createOrder($attributes);
            UponReceivingOrderCreated::dispatch($order);
        });

        return true;
    }

    public function createOnlinePaymentOrder(array $attributes) 
    {
        return DB::transaction(function () use($attributes) {
            $attributes['total_price'] = $this->priceCalculator->calculate($attributes);
            $attributes['status'] = OrderStatus::Pending;
    
            $paymentMethod = PaymentMethod::find($attributes['payment_method_id'])->method;
            if ($paymentMethod === PaymentMethods::UponReceiving) {
                throw new IncorrectPaymentMethodException('Incorrect payment method');
            }

            $payment = [
                'methods' => [strtolower($paymentMethod->value)],
                'capture' => ['descriptive' => 'Purchase in Book Store']
            ];
    
            $order = $this->createOrder($attributes);

            $customer = [
                'email' => 'some@email.com',
            ];
            $type = 'single';
            $orderData = [
                'key' => $order->id,
                'value' => $order->total_price,
            ];
        
            return $this->paymentService->createSession($type, $payment, $orderData, $customer);
        });
    }

    public function confirmOnlinePaymentOrder($data)
    {
        $order = Order::query()->find($data['key']);

        if ($order === null) {
            return;
        }

        if ($this->paymentService->confirmSession($data['id'])) {
            DB::transaction(function () use($order) {
                $order->update(['status' => OrderStatus::ReadyToSend]);
                OrderReadyToSend::dispatch($order);
            });
        }
  
    }

    private function createOrder(array $attributes): Order
    {
        $order = Order::create($attributes);

        foreach ($attributes['details'] as $detail) {
            $order->books()->attach($detail['book_id'], $detail);

            if ($detail['book_format'] === BookFormat::Paper->value) {
                Book::find($detail['book_id'])->paperFormat->decreaseQuantity($detail['quantity']);
            }
        }

        return $order;
    }
}
