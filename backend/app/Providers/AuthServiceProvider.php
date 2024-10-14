<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\V1\Addresses\Address;
use App\Models\V1\Addresses\Country;
use App\Models\V1\Addresses\DeliveryPlace;
use App\Models\V1\Addresses\District;
use App\Models\V1\Addresses\Region;
use App\Models\V1\Addresses\Settlement;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\Category;
use App\Models\V1\Books\Fragment;
use App\Models\V1\Books\Publisher;
use App\Models\V1\Books\Review;
use App\Models\V1\Orders\Order;
use App\Models\V1\Orders\ShippingMethod;
use App\Models\V1\User;
use App\Policies\Addresses\AddressPolicy;
use App\Policies\Addresses\CountryPolicy;
use App\Policies\Addresses\DeliveryPlacePolicy;
use App\Policies\Addresses\DistrictPolicy;
use App\Policies\Addresses\RegionPolicy;
use App\Policies\Addresses\SettlementPolicy;
use App\Policies\Books\AuthorPolicy;
use App\Policies\Books\BookPolicy;
use App\Policies\Books\CategoryPolicy;
use App\Policies\Books\FragmentPolicy;
use App\Policies\Books\PublisherPolicy;
use App\Policies\Books\ReviewPolicy;
use App\Policies\Orders\OrderPolicy;
use App\Policies\Orders\ShippingMethodPolicy;
use App\Policies\Users\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Author::class => AuthorPolicy::class,
        Publisher::class => PublisherPolicy::class,
        Fragment::class => FragmentPolicy::class,
        Review::class => ReviewPolicy::class,
        Book::class => BookPolicy::class,

        Country::class => CountryPolicy::class,
        District::class => DistrictPolicy::class,
        Region::class => RegionPolicy::class,
        Settlement::class => SettlementPolicy::class,
        DeliveryPlace::class => DeliveryPlacePolicy::class,

        User::class => UserPolicy::class,

        ShippingMethod::class => ShippingMethodPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
