<?php

namespace Tests\Feature\Api\V1\Books\BookManagment;

use App\Enums\BookFormat;
use App\Models\V1\Addresses\Country;
use App\Models\V1\Addresses\DeliveryPlace;
use App\Models\V1\Addresses\District;
use App\Models\V1\Addresses\Region;
use App\Models\V1\Addresses\Settlement;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\Category;
use App\Models\V1\Books\Publisher;
use App\Models\V1\Orders\Order;
use App\Models\V1\Orders\PaymentMethod;
use App\Models\V1\Orders\ShippingMethod;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownloadBookTestCase extends ApiV1TestCase
{
    use RefreshDatabase;

    protected Book $book;

    protected function setUp(): void
    {
        parent::setUp();

        $this->book = Book::factory()
            ->for(Publisher::factory())
            ->for(Category::factory())
            ->create();
    }

    protected function createOrder(BookFormat $bookFormat): void
    {
        $country = Country::factory()->create();
        $region = Region::factory()->for($country)->create();
        $district = District::factory()->for($region)->create();
        $settlement = Settlement::factory()->for($district)->create();

        $shippingMethod = ShippingMethod::factory()->create();
        $deliveryPlace = DeliveryPlace::factory()
            ->for($settlement)
            ->for($shippingMethod)
            ->create();


        Order::factory()
            ->for($this->customer)
            ->for(PaymentMethod::factory()->create())
            ->for($deliveryPlace)
            ->hasAttached(
                $this->book,
                [
                    'book_format' => $bookFormat,
                    'quantity' => 1,
                ]
            )
            ->create();
    }
}