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
            return $this->resourceWithSelectedFields($request);
        }

        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'description' => $this->description,
        ];
    }

    public function resourceWithSelectedFields(Request $request): array
    {
        $fields = explode(',', $request->fields['authors']);

        return [
            $this->mergeWhen(in_array('id', $fields), [
                'id' => $this->id
            ]),
            $this->mergeWhen(in_array('first_name', $fields),[
                'firstName' => $this->first_name
            ]),
            $this->mergeWhen(in_array('last_name', $fields),[
                'lastName' => $this->last_name
            ]),
            $this->mergeWhen(in_array('description', $fields),[
                'description' => $this->description
            ]),
        ];
    }
}
