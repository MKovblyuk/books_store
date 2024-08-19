<?php

namespace App\Services\Orders;

interface PaymentServiceInterface
{
    public function createSession($type, $payment, $order, $customer);
    public function confirmSession($id): bool;
}