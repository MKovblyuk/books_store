<?php

namespace App\Http\Transformers;

class OrderCreationInfoTransformer extends StatTransformer
{
    protected function transformDataItem($item): array
    {
        return [
            'ordersCount' => $item->orders_count
        ];
    } 
}