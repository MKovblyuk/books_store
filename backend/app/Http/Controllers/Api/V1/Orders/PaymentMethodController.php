<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Orders\PaymentMethodCollection;
use App\Models\V1\Orders\PaymentMethod;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PaymentMethodController extends Controller
{
    public function index()
    {   
        $paymentMethods = QueryBuilder::for(PaymentMethod::class)
            ->allowedFields([
                'id', 
                'method', 
                'name'
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'), 
                'method', 
                'name'
            ])
            ->allowedSorts([
                'id',
                'method',
                'name'
            ])
            ->get();

        return new PaymentMethodCollection($paymentMethods);
    }
}
