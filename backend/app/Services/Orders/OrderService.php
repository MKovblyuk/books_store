<?php

namespace App\Services\Orders;

use App\Enums\BookFormat;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Events\Orders\OrderReadyToSend;
use App\Events\Orders\UponReceivingOrderCreated;
use App\Exceptions\Orders\IncorrectPaymentMethodException;
use App\Jobs\ProcessPendingOrder;
use App\Models\V1\Books\PaperFormat;
use App\Models\V1\Orders\Order;
use App\Models\V1\Orders\PaymentMethod;
use App\Models\V1\User;
use Illuminate\Support\Facades\DB;

class OrderService
{
    private PaymentServiceInterface $paymentService;
    private PriceCalculatorService $priceCalculator;

    private const DEADLOCK_ATTEMPTS = 10;

    public function __construct(PaymentServiceInterface $paymentService, PriceCalculatorInterface $priceCalculator)
    {
        $this->paymentService = $paymentService;
        $this->priceCalculator = $priceCalculator;
    }

    public function createUponReceivingOrder(array $attributes): bool
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['total_price'] = $this->priceCalculator->calculate($attributes);
            $paymentMethod = PaymentMethod::find($attributes['payment_method_id'])->method;
    
            if ($paymentMethod !== PaymentMethods::UponReceiving) {
                throw new IncorrectPaymentMethodException('Incorrect payment method');
            }
    
            $order = $this->createOrder($attributes);
            
            if ($order) {
                UponReceivingOrderCreated::dispatch($order);
                return true;
            }
    
            return false;
        }, self::DEADLOCK_ATTEMPTS);
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
            ProcessPendingOrder::dispatch($order)->delay(now()->addMinutes(30));

            $user = User::find($attributes['user_id']);
            $customer = [
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone_number,
                'phone_indicative' => '+380',
            ];

            $type = 'single';
            $orderData = [
                'key' => $order->id,
                'value' => $order->total_price,
            ];
        
            return $this->paymentService->createSession($type, $payment, $orderData, $customer);
        }, self::DEADLOCK_ATTEMPTS);
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
                PaperFormat::lockForUpdate()->where('book_id', $detail['book_id'])->first()->decreaseQuantity($detail['quantity']);
            }
        }

        return $order;
    }
}
