<?php

namespace App\Http\Resources\V1\Addresses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'settlementName' => $this->settlement_name,
            'streetName' => $this->street_name,
            'streetNumber' => $this->street_number,
            'postalCode' => $this->postal_code,
            'districtName' => $this->districtName,
            'regionName' => $this->regionName,
            'countryName' => $this->countryName,
        ];
    }
}
