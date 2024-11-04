<?php

namespace Database\Seeders\Orders;

use App\Enums\PaymentMethods;
use App\Models\V1\Orders\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (PaymentMethods::cases() as $paymentMethod) {
            PaymentMethod::create([
                'method' => $paymentMethod,
            ]);
        }
    }
}
