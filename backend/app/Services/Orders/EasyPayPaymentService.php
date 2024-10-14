<?php 

namespace App\Services\Orders;

use Illuminate\Support\Facades\Http;

class EasyPayPaymentService implements PaymentServiceInterface
{
    private string $apiKey;
    private string $accountId;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('payment.easypay.api_key');
        $this->accountId = config('payment.easypay.account_id');
        $this->apiUrl = config('payment.easypay.api_url');
    }

    public function createSession($type, $payment, $orderData, $customer)
    {
        return Http::withHeaders([
            'AccountId' => $this->accountId,
            'ApiKey' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '/checkout', [
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
            'AccountId' => $this->accountId,
            'ApiKey' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->get($this->apiUrl . '/single/' . $id);

        return $response->status() === 200;
    }
}