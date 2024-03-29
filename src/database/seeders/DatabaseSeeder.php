<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Addresses\AddressSeeder;
use Database\Seeders\Addresses\CountrySeeder;
use Database\Seeders\Addresses\DistrictSeeder;
use Database\Seeders\Addresses\RegionSeeder;
use Database\Seeders\Books\AuthorSeeder;
use Database\Seeders\Books\BookSeeder;
use Database\Seeders\Books\CategorySeeder;
use Database\Seeders\Books\FragmentSeeder;
use Database\Seeders\Books\LikedBookSeeder;
use Database\Seeders\Books\PublisherSeeder;
use Database\Seeders\Books\ReviewSeeder;
use Database\Seeders\Orders\OrderSeeder;
use Database\Seeders\Orders\ShippingMethodSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CountrySeeder::class,
            RegionSeeder::class,
            DistrictSeeder::class,
            AddressSeeder::class,
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
            ShippingMethodSeeder::class,
            OrderSeeder::class,
        ]);

    }
}
