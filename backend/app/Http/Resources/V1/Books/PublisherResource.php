<?php

namespace App\Http\Resources\V1\Books;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublisherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if (isset($request->fields)) {
            return [
                $this->mergeWhen(in_array('id', $request->fields),
                    ['id' => $this->id],
                ),
    
                $this->mergeWhen(in_array('name', $request->fields),
                    ['name' => $this->name],
                ),
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
