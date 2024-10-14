<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Actions\Orders\GetPaymentMethodsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Orders\PaymentMethodCollection;

class PaymentMethodController extends Controller
{
    public function index(GetPaymentMethodsAction $action)
    {   
        return new PaymentMethodCollection($action->execute());
    }
}
