<?php

namespace App\Actions\Orders;

use App\Enums\BookFormat;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Enums\ShippingMethods;
use App\Events\Orders\OrderReadyToSend;
use App\Events\Orders\UponReceivingOrderCreated;
use App\Factories\ShippingServiceFactory;
use App\Models\V1\Books\Book;
use App\Models\V1\Orders\Order;
use App\Models\V1\Orders\PaymentMethod;
use App\Models\V1\Orders\ShippingMethod;
use App\Services\Orders\PaymentServiceInterface;
use App\Services\Orders\PriceCalculatorInterface;
use App\Services\Orders\PriceCalculatorService;
use Exception;
use Illuminate\Support\Facades\DB;



class CreateOrderAction 
{
    private PaymentServiceInterface $paymentService;
    private PriceCalculatorService $priceCalculator;

    public function __construct(PaymentServiceInterface $paymentService, PriceCalculatorInterface $priceCalculator)
    {
        $this->paymentService = $paymentService;
        $this->priceCalculator = $priceCalculator;
    }

    public function execute(array $attributes): bool
    {
        $attributes['total_price'] = $this->priceCalculator->calculate($attributes);
        $paymentMethod = PaymentMethod::find($attributes['payment_method_id'])->method;

        if($paymentMethod !== PaymentMethods::UponReceiving) {
            throw new Exception('Incorrect payment method');
        }

        if ($paymentMethod === PaymentMethods::UponReceiving) {
            DB::transaction(function () use($attributes){
                $order = $this->createOrder($attributes);
                UponReceivingOrderCreated::dispatch($order);
            });
        } else {
            DB::transaction(function () use($attributes, $paymentMethod){

                // $shippingMethod = ShippingMethod::find($attributes['shipping_method_id']);
                // $shippingService = ShippingServiceFactory::create($shippingMethod->name);



                $attributes['status'] = OrderStatus::Pending;
                $order = $this->createOrder($attributes);

                $paymentIsSuccess = $this->paymentService->singlePayment(1, $attributes['total_price'], $paymentMethod);
                if (!$paymentIsSuccess) {
                    throw new Exception('Error in payment service');
                }

                OrderReadyToSend::dispatch($order);
            });
        }

        return true;
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