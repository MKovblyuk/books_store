<?php

namespace App\Http\Resources\V1\Orders;

use App\Http\Resources\V1\Addresses\DeliveryPlaceResource;
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
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'totalPrice' => $this->total_price, 

            'userId' => $this->when($this->fieldIsNotIncluded('user', $request),
                $this->user_id
            ),
            'user' => $this->when($this->fieldIsIncluded('user', $request),
                fn () => new UserResource($this->user)
            ),

            'deliveryPlaceId' => $this->when($this->fieldIsNotIncluded('deliveryPlace', $request),
                $this->delivery_place_id
            ),
            'deliveryPlace' => $this->when($this->fieldIsIncluded('deliveryPlace', $request),
                fn () => new DeliveryPlaceResource($this->deliveryPlace)
            ),

            'paymentMethodId' => $this->when($this->fieldIsNotIncluded('paymentMethod', $request),
                $this->payment_method_id
            ),
            'paymentMethod' => $this->when($this->fieldIsIncluded('paymentMethod', $request),
                fn () => new PaymentMethodResource($this->paymentMethod)
            ),

            'books' => $this->when($this->fieldIsIncluded('books', $request),
                fn () => new BookCollection($this->books)
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
            $this->mergeWhen(in_array('delivery_place_id', $fields), [
                'deliveryPlaceId' => $this->deliveryPlace
            ]),
            $this->mergeWhen(in_array('created_at', $fields), 
                ['createdAt' => $this->created_at]
            ),
            $this->mergeWhen(in_array('updated_at', $fields), 
                ['updatedAt' => $this->updated_at]
            ),
        ];
    }
}
