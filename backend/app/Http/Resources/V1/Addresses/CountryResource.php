<?php

namespace App\Http\Resources\V1\Addresses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (isset($request->fields)){
            return $this->resourceWithSelectedFields($request);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public function resourceWithSelectedFields(Request $request): array
    {
        $fields = explode(',', $request->fields['countries']);

        return [
            $this->mergeWhen(in_array('id', $fields), 
                ['id' => $this->id]
            ),
            $this->mergeWhen(in_array('name', $fields),
                ['name' => $this->name]
            )
        ];
    }
}
