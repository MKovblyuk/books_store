<?php

namespace App\Http\Requests\V1\Orders;

use App\Exceptions\Http\FailedValidationHttpResponseException;
use App\Rules\OrderDatails;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        // return request()->user() !== null;
        return true;
    }

    public function rules(): array
    {
        return [
            'address_id' => ['required', 'exists:addresses,id'],
            'user_id' => ['required', 'exists:users,id'],
            'shipping_method_id' => ['required', 'exists:shipping_methods,id'],
            'details' => ['required', 'array', new OrderDatails()],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        if (isset(request()->user()->id)) {
            $this->merge(['user_id' => request()->user()->id]);
        }
        else {
            // TODO change to guest user
            $this->merge(['user_id' => '1']);
        }

        if (isset($this->addressId)) {
            $this->merge(['address_id' => $this->addressId ]);
        }
        if (isset($this->shippingMethodId)) {
            $this->merge(['shipping_method_id' => $this->shippingMethodId]);
        }
        if (isset($this->details)) {
            $this->merge(['details' => $this->prepareDetailsForValidation($this->details)]);
        }
    }

    private function prepareDetailsForValidation(array $details): array
    {
        for ($i = 0; $i < count($details); $i++) {
            if (isset($details[$i]['bookId'])) {
                $details[$i]['book_id'] = $details[$i]['bookId'];
                unset($details[$i]['bookId']);
            }
            if (isset($details[$i]['bookFormat'])) {
                $details[$i]['book_format'] = $details[$i]['bookFormat'];
                unset($details[$i]['bookFormat']);
            }
        }

        return $details;
    }

}
