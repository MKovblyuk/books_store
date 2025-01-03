<?php

namespace App\Http\Resources\V1\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'ordersCount' => $this->orders_count,
            'receivedOrdersCount' => $this->received_orders_count,
            'notReceivedOrdersCount' => $this->not_received_orders_count,
            'totalAmountOfPurchases' => $this->total_amount_of_purchases,
        ];
    }
}
