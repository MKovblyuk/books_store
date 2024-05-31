<?php

namespace App\Policies\Orders;

use App\Models\V1\Orders\ShippingMethod;
use App\Models\V1\User;
use Illuminate\Auth\Access\Response;

class ShippingMethodPolicy
{
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ShippingMethod $shippingMethod): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ShippingMethod $shippingMethod): bool
    {
        return false;
    }

    public function delete(User $user, ShippingMethod $shippingMethod): bool
    {
        return false;
    }

    public function restore(User $user, ShippingMethod $shippingMethod): bool
    {
        return false;
    }

    public function forceDelete(User $user, ShippingMethod $shippingMethod): bool
    {
        return false;
    }
}
