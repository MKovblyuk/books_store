<?php

namespace App\Http\Resources\V1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (isset($request->fields)) {
            return $this->resourceWithSelectedFields($request);
        }

        return [
            'id' => $this->id,
            'method' => $this->method,
        ];
    }

    public function resourceWithSelectedFields(Request $request): array
    {
        $fields = explode(',', $request->fields['payment_methods']);

        return [
            $this->mergeWhen(in_array('id', $fields), [
                'id' => $this->id,
            ]),
            $this->mergeWhen(in_array('method', $fields), [
                'method' => $this->method,
            ]),
        ];
    }
}
