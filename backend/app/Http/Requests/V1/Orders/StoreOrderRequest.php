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
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'delivery_place_id' => ['required', 'exists:delivery_places,id'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
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
        if (isset($this->deliveryPlaceId)) {
            $this->merge(['delivery_place_id' => $this->deliveryPlaceId]);
        }
        if (isset($this->details)) {
            $this->merge(['details' => $this->prepareDetailsForValidation($this->details)]);
        }
        if (isset($this->paymentMethodId)) {
            $this->merge(['payment_method_id' => $this->paymentMethodId]);
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
