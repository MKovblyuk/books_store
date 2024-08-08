<?php

namespace App\Http\Resources\V1\Orders;

use App\Traits\AllowedIncludes;
use App\Http\Resources\V1\Books\BookCollection;
use App\Http\Resources\V1\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    use AllowedIncludes;

    public function toArray(Request $request): array
    {
        if (isset($request->fields)) {
            return $this->resourceWithSelectedFields($request);
        }

        return [
            'id' => $this->id,
            'status' => $this->status,
            'addressId' => $this->address_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            $this->mergeWhen($this->fieldIsNotIncluded('user', $request), 
                ['userId' => $this->user_id,]
            ),
            $this->mergeWhen($this->fieldIsIncluded('user', $request),
                ['user' => new UserResource($this->user)]
            ),

            $this->mergeWhen($this->fieldIsNotIncluded('shippingMethod', $request), 
                ['shippingMethodId' => $this->shipping_method_id]
            ),
            $this->mergeWhen($this->fieldIsIncluded('shippingMethod', $request), 
                ['shippingMethod' => new ShippingMethodResource($this->shippingMethod)]
            ),

            $this->mergeWhen($this->fieldIsIncluded('books', $request),
                ['books' => new BookCollection($this->books)]
            ),

            $this->mergeWhen($this->fieldIsIncluded('details', $request),
                ['details' => $this->details()]
            ),
        ];
    }

    public function resourceWithSelectedFields(Request $request): array
    {
        $fields = explode(',', $request->fields['orders']);

        return [
            $this->mergeWhen(in_array('id', $fields), 
                ['id' => $this->id]
            ),
            $this->mergeWhen(in_array('status', $fields), 
                ['status' => $this->status]
            ),
            $this->mergeWhen(in_array('user_id', $fields), 
                ['userId' => $this->user_id]
            ),
            $this->mergeWhen(in_array('address_id', $fields), 
                ['addressId' => $this->address_id]
            ),
            $this->mergeWhen(in_array('shipping_method_id', $fields), 
                ['shippingMethodId' => $this->shipping_method_id]
            ),
            $this->mergeWhen(in_array('created_at', $fields), 
                ['createdAt' => $this->created_at]
            ),
            $this->mergeWhen(in_array('updated_at', $fields), 
                ['updatedAt' => $this->updated_at]
            ),
            $this->mergeWhen(in_array('details', $fields),
                ['details' => $this->details()]
            ),
        ];
    }
}
