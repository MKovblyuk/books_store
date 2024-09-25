<?php

namespace App\Policies\Addresses;

use App\Models\V1\Addresses\DeliveryPlace;
use App\Models\V1\User;


class DeliveryPlacePolicy {
    public function before(User $user, string $ability): bool|null 
    {
        return $user->isAdmin() || $user->isEditor() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, DeliveryPlace $deliveryPlace): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, DeliveryPlace $deliveryPlace): bool
    {
        return false;
    }

    public function delete(User $user, DeliveryPlace $deliveryPlace): bool
    {
        return false;
    }

    public function restore(User $user, DeliveryPlace $deliveryPlace): bool
    {
        return false;
    }

    public function forceDelete(User $user, DeliveryPlace $deliveryPlace): bool
    {
        return false;
    }
}