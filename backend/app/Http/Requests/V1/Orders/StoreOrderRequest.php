<?php

namespace App\Http\Requests\V1\Orders;

// use App\Enums\BookFormat;

use App\Enums\BookFormat;
use App\Exceptions\Http\FailedValidationHttpResponseException;
use App\Rules\OrderDatails;
use App\Rules\PaymentMethod;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'details' => ['required', 'array', new OrderDatails()],
            'payment_method_id' => ['required', 'exists:payment_methods,id', new PaymentMethod($this->details)],
            'delivery_place_id' => [
                Rule::requiredIf($this->deliveryPlaceIsRequired($this['details'])), 
                'exists:delivery_places,id'
            ],
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

    private function deliveryPlaceIsRequired($booksDetails): bool
    {
        foreach ($booksDetails as $detail) {
            if (BookFormat::from($detail['book_format']) === BookFormat::Paper) {
                return true;
            }
        }

        return false;
    }
}
