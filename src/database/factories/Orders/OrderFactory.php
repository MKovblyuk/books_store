<?php

namespace Database\Factories\Orders;

use App\Enums\OrderStatus;
use App\Models\Addressess\Address;
use App\Models\Orders\ShippingMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order_statuses = array_column(OrderStatus::cases(), 'name');

        return [
            'date' => fake()->dateTime(),
            'status' => $order_statuses[array_rand($order_statuses)],
            'user_id' => User::all()->random()->id,
            'address_id' => Address::all()->random()->id,
            'shipping_method_id' => ShippingMethod::all()->random()->id,
        ];
    }
}
