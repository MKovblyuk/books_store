<?php

namespace App\Http\Resources\V1\Addresses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (isset($request->fields)) {
            return $this->resourceWithSelectedFields($request);
        }

        return [
            'id' => $this->id,
            'settlementName' => $this->settlement_name,
            'streetName' => $this->street_name,
            'streetNumber' => $this->street_number,
            'postalCode' => $this->postal_code,

            $this->mergeWhen($this->fieldIsNotIncluded('district', $request),
                ['districtId' => $this->district_id]
            ),
            $this->mergeWhen($this->fieldIsIncluded('district', $request),
                ['district' => new DistrictResource($this->district)]
            ),
            
        ];
    }

    public function resourceWithSelectedFields(Request $request): array
    {
        $fields = explode(',', $request->fields['addresses']);

        return [
            $this->mergeWhen(in_array('id', $fields), 
                ['id' => $this->id]
            ),
            $this->mergeWhen(in_array('settlement_name', $fields), 
                ['settlementName' => $this->settlement_name]
            ),
            $this->mergeWhen(in_array('street_name', $fields), 
                ['streetName' => $this->street_name]
            ),
            $this->mergeWhen(in_array('street_number', $fields), 
                ['streetNumber' => $this->street_number]
            ),
            $this->mergeWhen(in_array('postal_code', $fields), 
                ['postalCode' => $this->postal_code]
            ),
            $this->mergeWhen(in_array('district_id', $fields), 
                ['districtId' => $this->district_id]
            ),
        ];
    }

    private function fieldIsIncluded(string $field, Request $request): bool
    {
        return isset($request->include) && in_array($field, explode(',', $request->include));
    }

    private function fieldIsNotIncluded(string $field, Request $request): bool
    {
        return !$this->fieldIsIncluded($field, $request);
    }
}
