<?php

namespace App\Actions\Orders;

use App\Enums\OrderStatus;
use App\Models\V1\Orders\PaymentMethod;
use Illuminate\Support\Facades\DB;

class ConfirmOrderPaymentAction
{
    public function execute($id)
    {
        // $attributes = session('order_attributes');
        // $paymentMethod = PaymentMethod::find($attributes['payment_method_id'])->method;
        // DB::transaction(function () use($attributes, $paymentMethod){

        //     // $shippingMethod = ShippingMethod::find($attributes['shipping_method_id']);
        //     // $shippingService = ShippingServiceFactory::create($shippingMethod->name);
            
        //     $attributes['status'] = OrderStatus::ReadyToSend;
        //     $order = $this->createOrder($attributes);

        //     $paymentIsSuccess = $this->paymentService->singlePayment(1, $attributes['total_price'], $paymentMethod);
        //     if (!$paymentIsSuccess) {
        //         throw new Exception('Error in payment service');
        //     }

        //     OrderReadyToSend::dispatch($order);
        // });
    }
}