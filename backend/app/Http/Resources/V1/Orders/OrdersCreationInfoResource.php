<?php

namespace App\Http\Resources\V1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersCreationInfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ordersCount' => $this->orders_count,
            'creationDate' => $this->creation_date,
        ];
    }
}