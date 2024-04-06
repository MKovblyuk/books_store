<?php

namespace App\Policies\Orders;

use App\Models\V1\Orders\Order;
use App\Models\V1\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Order $order): bool
    {
        return false;
    }

    public function delete(User $user, Order $order): bool
    {
        return false;
    }

    public function restore(User $user, Order $order): bool
    {
        return false;
    }

    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }

    public function showDetails(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }
}
