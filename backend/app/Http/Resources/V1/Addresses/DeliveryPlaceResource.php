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

            $this->mergeWhen($this->fieldIsNotIncluded('settlement', $request), [
                'settlementId' => $this->settlement_id,
            ]),
            $this->mergeWhen($this->fieldIsIncluded('settlement', $request), [
                'settlement' => new SettlementResource($this->settlement),
            ]),

            $this->mergeWhen($this->fieldIsNotIncluded('shippingMethod', $request), [
                'shippingMethodId' => $this->shipping_method_id,
            ]),
            $this->mergeWhen($this->fieldIsIncluded('shippingMethod', $request), [
                'shippingMethod' => new ShippingMethodResource($this->shippingMethod),
            ]),
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