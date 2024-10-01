<?php

namespace App\Http\Resources\V1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'totalPrice' => $this->total_price, 
            'userId' => $this->user_id,

            $this->mergeWhen(isset($this->deliveryPlace), fn() => [
                'country' => $this->deliveryPlace->settlement->district->region->country->name,
                'region' => $this->deliveryPlace->settlement->district->region->name,
                'district' => $this->deliveryPlace->settlement->district->name,
                'settlement' => $this->deliveryPlace->settlement->name,
                'streetAddress' => $this->deliveryPlace->street_address,
                'shippingMethod' => $this->deliveryPlace->shippingMethod->name,
            ]),
        ];
    }
}
