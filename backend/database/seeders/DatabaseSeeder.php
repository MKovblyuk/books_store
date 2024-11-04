<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\V1\Orders\ShippingMethod;
use Database\Seeders\Addresses\AddressSeeder;
use Database\Seeders\Addresses\TestAddressSeeder;
use Database\Seeders\Books\AuthorSeeder;
use Database\Seeders\Books\BookSeeder;
use Database\Seeders\Books\CategorySeeder;
use Database\Seeders\Books\FragmentSeeder;
use Database\Seeders\Books\LikedBookSeeder;
use Database\Seeders\Books\PublisherSeeder;
use Database\Seeders\Books\ReviewSeeder;
use Database\Seeders\Orders\OrderSeeder;
use Database\Seeders\Orders\PaymentMethodSeeder;
use Database\Seeders\Orders\ShippingMethodSeeder;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ShippingMethodSeeder::class,

            // AddressSeeder::class,
            TestAddressSeeder::class,
        ]);

        $this->call([
            PublisherSeeder::class,
            AuthorSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
            FragmentSeeder::class,
        ]);

        $this->call([
            UserSeeder::class,
            ReviewSeeder::class,
            LikedBookSeeder::class,
        ]);

        $this->call([
            PaymentMethodSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
