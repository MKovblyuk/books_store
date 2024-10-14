<?php

namespace App\Http\Resources\V1\Addresses;

use App\Traits\AllowedIncludes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    use AllowedIncludes;

    public function toArray(Request $request): array
    {
        if (isset($request->fields)) {
            return $this->resourceWithSelectedFields($request);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,

            $this->mergeWhen($this->fieldIsNotIncluded('country', $request), 
                ['countryId' => $this->country_id,]
            ),
            $this->mergeWhen($this->fieldIsIncluded('country', $request), 
                ['country' => new CountryResource($this->country)]
            ),
            
        ];
    }

    public function resourceWithSelectedFields(Request $request): array
    {
        $fields = explode(',', $request->fields['regions']);

        return [
            $this->mergeWhen(in_array('id', $fields), 
                ['id' => $this->id]
            ),
            $this->mergeWhen(in_array('name', $fields), 
                ['name' => $this->name]
            ),
            $this->mergeWhen(in_array('country_id', $fields), 
                ['countryId' => $this->country_id]
            ),
        ];
    }
}
