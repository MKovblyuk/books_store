<?php

namespace App\Actions\Orders;

use App\Models\V1\Orders\PaymentMethod;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetPaymentMethodsAction
{
    public function execute()
    {
        return QueryBuilder::for(PaymentMethod::class)
            ->allowedFields([
                'id', 
                'method', 
                'name',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'), 
                'method', 
                'name',
            ])
            ->allowedSorts([
                'id',
                'method',
                'name',
            ])
            ->get();
    }
}