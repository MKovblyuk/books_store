<?php

namespace App\Http\Resources\V1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'bookId' => $this->book_id,
            'bookType' => $this->book_type,
            'quantity' => $this->quantity,
            'totalPrice' => $this->total_price,
        ];
    }
}
