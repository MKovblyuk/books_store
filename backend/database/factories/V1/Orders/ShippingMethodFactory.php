<?php

namespace Database\Factories\V1\Orders;

use App\Enums\ShippingMethods;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\Order>
 */
class ShippingMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ShippingMethods::cases()[array_rand(ShippingMethods::cases())],
        ];
    }
}
