<?php

namespace App\Http\Resources\V1\Addresses;

use App\Traits\AllowedIncludes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettlementResource extends JsonResource
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

            'districtId' => $this->when($this->fieldIsNotIncluded('district', $request), 
                $this->district_id
            ),
            'district' => $this->when($this->fieldIsIncluded('district', $request),
                fn () => new DistrictResource($this->district)
            ),
        ];
    }

    public function resourceWithSelectedFields(Request $request)
    {
        $fields = explode(',', $request->fields['settlements']);

        return [
            $this->mergeWhen(in_array('id', $fields),[
                'id' => $this->id
            ]),
            $this->mergeWhen(in_array('name', $fields), [
                'name' => $this->name
            ]),
            $this->mergeWhen(in_array('district_id', $fields),[
                'districtId' => $this->district_id
            ]),
        ];
    }
}
