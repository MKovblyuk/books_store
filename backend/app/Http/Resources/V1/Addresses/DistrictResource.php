<?php

namespace App\Http\Resources\V1\Addresses;

use App\Traits\AllowedIncludes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
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

            $this->mergeWhen($this->fieldIsNotIncluded('region', $request), 
                ['regionId' => $this->region_id]
            ),
            $this->mergeWhen($this->fieldIsIncluded('region', $request),
                ['region' => new RegionResource($this->region)]
            ),
        ];
    }

    public function resourceWithSelectedFields(Request $request): array
    {
        $fields = explode(',', $request->fields['districts']);

        return [
            $this->mergeWhen(in_array('id', $fields), 
                ['id' => $this->id]
            ),
            $this->mergeWhen(in_array('name', $fields),
                ['name' => $this->name]
            ),
            $this->mergeWhen(in_array('region_id', $fields),
                ['regionId' => $this->region_id]
            ),
        ];
    }
}
