<?php

namespace Database\Seeders\Addresses;

use App\Factories\AddressFromShippingServiceFactory;
use App\Factories\AddressFromNovaposhtaFactory;
use App\Services\Orders\NovaposhtaService;
use App\Services\Orders\ShippingServiceInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    private array $shippingServices = [
        NovaposhtaService::class => AddressFromNovaposhtaFactory::class
    ];

    public function run(): void
    {
        DB::transaction(function() {
            foreach ($this->shippingServices as $service => $factory) {
                $this->seedAddresses(new $service(), new $factory());
            }
        });
    }

    private function seedAddresses(ShippingServiceInterface $service, AddressFromShippingServiceFactory $factory)
    {
        foreach ($service->getCountries() as $country) {
            $dbCountry = $factory->createCountry($country);

            foreach ($service->getRegions($country) as $region) {
                $dbRegion = $factory->createRegion($region, $dbCountry->id);
    
                foreach ($service->getDistricts($region) as $district) {
                    $dbDistrict = $factory->createDistrict($district, $dbRegion->id);

                    foreach ($service->getSettlements($district) as $settlement) {
                        $dbSettlement = $factory->createSettlement($settlement, $dbDistrict->id);

                        foreach ($service->getDeliveryPlaces($settlement) as $deliveryPlace) {
                            $factory->createDelivryPlace($deliveryPlace, $dbSettlement->id);
                        }
                    }
                }
            }
        }
    }
}
