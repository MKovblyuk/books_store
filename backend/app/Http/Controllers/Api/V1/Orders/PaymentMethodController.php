<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use App\Models\V1\Orders\PaymentMethod;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        return PaymentMethod::all();
    }
}
