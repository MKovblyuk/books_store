<?php

namespace Database\Factories\V1\Orders;

use App\Enums\PaymentMethods;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\Order>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'method' => PaymentMethods::cases()[array_rand(PaymentMethods::cases())],
        ];
    }
}
