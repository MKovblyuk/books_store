<?php

namespace App\Actions\Users;

use App\Enums\OrderStatus;
use App\Models\V1\User;
use Illuminate\Support\Facades\DB;

class GetUserDetailsAction
{
    public function execute(User $user)
    {
        return User::query()
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                DB::raw('COUNT(orders.id) as orders_count'),
                DB::raw('SUM(CASE WHEN orders.status = "'. OrderStatus::Received->value .'" THEN 1 ELSE 0 END) as received_orders_count'),
                DB::raw('SUM(CASE WHEN orders.status != "'. OrderStatus::Received->value .'" THEN 1 ELSE 0 END) as not_received_orders_count'),
                DB::raw('SUM(CASE WHEN orders.status = "'. OrderStatus::Received->value .'" THEN orders.total_price ELSE 0 END) as total_amount_of_purchases')
            )
            ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->where('users.id', $user->id)
            ->groupBy('users.id')
            ->first();
    }
}