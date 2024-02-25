<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Books\LikedBook;
use Database\Seeders\Addressess\AddressSeeder;
use Database\Seeders\Addressess\CountrySeeder;
use Database\Seeders\Addressess\DistrictSeeder;
use Database\Seeders\Addressess\RegionSeeder;
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
