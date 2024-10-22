<?php

namespace App\Services\Orders;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class NovaposhtaService implements ShippingServiceInterface
{
    private string $apiKey;
    private string $apiUrl;

    const RETRIES_COUNT = 5;
    const RETRIES_TIMEOUT = 1000;


    public function __construct()
    {
        $this->apiKey = config('shipping.nova_poshta.api_key');
        $this->apiUrl = config('shipping.nova_poshta.api_url');
    }

    public function getCountries(): array
    {
        return [
            [
                'id' => 1,
                "Description" => "Україна",
            ],
        ];
    }

    public function getRegions($country = null): array
    {
        $response = Http::withResponseMiddleware(
            function(ResponseInterface $response) {
                $this->checkOnErrors($response);
                return $response;
            }
        )
        ->retry(self::RETRIES_COUNT, self::RETRIES_TIMEOUT)
        ->post($this->apiUrl, [
            'apiKey' => $this->apiKey,
            "modelName" => "AddressGeneral",
            "calledMethod" => "getSettlementAreas",
            "methodProperties" => [
                "Ref" => "",
            ],
        ]);

        return $response->json('data');
    }

    public function getDistricts($region): array
    {
        $response = Http::withResponseMiddleware(
            function(ResponseInterface $response) {
                $this->checkOnErrors($response);
                return $response;
            }
        )
        ->retry(self::RETRIES_COUNT, self::RETRIES_TIMEOUT)
        ->post($this->apiUrl, [
            'apiKey' => $this->apiKey,
            "modelName" => "AddressGeneral",
            "calledMethod" => "getSettlementCountryRegion",
            "methodProperties" => [
                "AreaRef" => $region['Ref'],
            ],
        ]);

        return $response->json('data');
    }

    public function getSettlements($district, int $page = 1, int $limit = 20): array
    {
        $data = $this->fetchSettlementsData([
            "RegionRef" => $district['Ref'],
            "Warehouse" => "1",
        ]);

        // receiving the regional center additionally

        if ($district['RegionType'] === 'район') {
            $settlements = $this->fetchSettlementsData([
                "Ref" => $district['AreasCenter'],
                "Warehouse" => "1",
            ]);
     
            if (!empty($settlements)) {
                $adminCenter = $settlements[0];
            } else {
                return $data;
            }
    
            if ((new Collection($data))->doesntContain('Ref', $adminCenter['Ref'])) {
                $data[] = $adminCenter;
            }
        } 

        return $data;
    }

    private function fetchSettlementsData(array $methodProperties): array
    {
        return Http::withResponseMiddleware(
            function(ResponseInterface $response) {
                $this->checkOnErrors($response);
                return $response;
            }
        )
        ->retry(self::RETRIES_COUNT, self::RETRIES_TIMEOUT)
        ->post($this->apiUrl, [
            'apiKey' => $this->apiKey,
            "modelName" => "AddressGeneral",
            "calledMethod" => "getSettlements",
            "methodProperties" => $methodProperties,
        ])
        ->json('data');
    }

    public function getDeliveryPlaces($settlement): array
    {
        $response = Http::withResponseMiddleware(
            function(ResponseInterface $response) {
                $this->checkOnErrors($response);
                return $response;
            }
        )
        ->retry(self::RETRIES_COUNT, self::RETRIES_TIMEOUT)
        ->post($this->apiUrl, [
            'apiKey' => $this->apiKey,
            "modelName" => "AddressGeneral",
            "calledMethod" => "getWarehouses",
            "methodProperties" => [
                "SettlementRef" => $settlement['Ref'],
            ],
        ]);

        return $response->json('data');
    }

    private function checkOnErrors(ResponseInterface $response)
    {
        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['success']) {
            return;
        }

        foreach ($data['errorCodes'] as $errorCode) {
            if ($errorCode === "20000401501") {
                throw new TooManyRequestsHttpException();
            }
        }

        throw new HttpClientException(json_encode($data));
    }
}