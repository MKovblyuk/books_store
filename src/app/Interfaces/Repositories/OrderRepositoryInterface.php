<?php

namespace App\Interfaces\Repositories;

use App\Models\V1\Orders\Order;

interface OrderRepositoryInterface {
    public function getAll();
    public function store(array $attributes): bool;
    public function update(Order $order, array $attributes): bool;
    public function destroy(Order $order): bool;
}