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
            'streetAddress' => $this->street_address,
            'settlementName' => $this->settlement->name,
            'districtName' => $this->settlement->district->name,
            'regionName' => $this->settlement->district->region->name,
            'countryName' => $this->settlement->district->region->country->name,
        ];
    }
}
