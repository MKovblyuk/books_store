<?php

namespace App\Http\Resources\V1\Addresses;

use App\Http\Resources\V1\Orders\ShippingMethodResource;
use App\Traits\AllowedIncludes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryPlaceResource extends JsonResource
{
    use AllowedIncludes;

    public function toArray(Request $request): array
    {
        if (isset($request->fields)) {
            return $this->resourceWithSelectedFields($request);
        }
        return [
            'id' => $this->id,
            'streetAddress' => $this->street_address,

            'settlementId' => $this->when($this->fieldIsNotIncluded('settlement', $request), 
                $this->settlement_id
            ),
            'settlement' => $this->when($this->fieldIsIncluded('settlement', $request), 
                fn () => new SettlementResource($this->settlement)
            ),

            'shippingMethodId' => $this->when($this->fieldIsNotIncluded('shippingMethod', $request), 
                $this->shipping_method_id
            ),
            'shippingMethod' => $this->when($this->fieldIsIncluded('shippingMethod', $request), 
                fn () => new ShippingMethodResource($this->shippingMethod)
            ),
        ];
    }

    public function resourceWithSelectedFields(Request $request): array
    {
        $fields = explode(',', $request->fields['delivery_places']);

        return [
            $this->mergeWhen(in_array('id', $fields), [
                'id' => $this->id
            ]),
            $this->mergeWhen(in_array('street_address', $fields), [
                'streetAddress' => $this->street_address
            ]),
            $this->mergeWhen(in_array('settlement_id', $fields), [
                'settlmentId' => $this->settlement_id
            ]),
            $this->mergeWhen(in_array('shipping_method_id', $fields), [
                'shippingMethodId' => $this->shipping_method_id
            ]),
        ];
    }
}