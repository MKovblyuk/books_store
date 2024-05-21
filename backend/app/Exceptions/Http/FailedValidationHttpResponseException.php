<?php

namespace App\Exceptions\Http;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FailedValidationHttpResponseException extends HttpResponseException
{
    public function __construct(Validator $validator, int $code = 422, $message = "Invalid data")
    {
        $response = response()->json([
            'message' => $message,
            'errors' => $validator->errors()->messages(),
        ], $code);

        parent::__construct($response);
    }
}
