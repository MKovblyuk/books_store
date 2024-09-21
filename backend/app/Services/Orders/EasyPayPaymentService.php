<?php 

namespace App\Services\Orders;

use Illuminate\Support\Facades\Http;

class EasyPayPaymentService implements PaymentServiceInterface
{
    public function createSession($type, $payment, $orderData, $customer)
    {
        return Http::withHeaders([
            'AccountId' => env('EASY_PAY_ACCOUNT_ID'),
            'ApiKey' => env('EASY_PAY_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('EASY_PAY_API_URL') . '/checkout', [
            'type' => [$type],
            'payment' => $payment,
            'order' => [
                'key' => (string) $orderData['key'],
                'value' => (float) $orderData['value']
            ],
            'customer' => $customer
        ])->json();
    }

    public function confirmSession($id): bool
    {
        $response = Http::withHeaders([
            'AccountId' => env('EASY_PAY_ACCOUNT_ID'),
            'ApiKey' => env('EASY_PAY_API_KEY'),
            'Content-Type' => 'application/json',
        ])->get(env('EASY_PAY_API_URL') . '/single/' . $id);

        return $response->status() === 200;
    }
}