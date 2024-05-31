<?php

namespace App\Http\Resources\V1\Books;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if(isset($request->fields)){
            return [
                $this->mergeWhen(in_array('id', $request->fields), 
                    ['id' => $this->id]
                ),
                $this->mergeWhen(in_array('first_name', $request->fields),
                    ['firstName' => $this->first_name]
                ),
                $this->mergeWhen(in_array('last_name', $request->fields),
                    ['lastName' => $this->last_name]
                ),
                $this->mergeWhen(in_array('description', $request->fields),
                    ['description' => $this->description]
                ),
                $this->mergeWhen(in_array('photo_url', $request->fields),
                    ['photoUrl' => $this->photo_url]
                ),
            ];
        }

        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'description' => $this->description,
            'photoUrl' => $this->photo_url,
        ];
    }
}
