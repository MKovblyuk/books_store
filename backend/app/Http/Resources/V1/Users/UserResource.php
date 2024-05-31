<?php

namespace App\Http\Resources\V1\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (isset($request->fields)) {
            return $this->resourceWithSelectedFields($request);
        }

        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'role' => $this->role,
            'phoneNumber' => $this->phone_number,

            // $this->mergeWhen($this->fieldIsIncluded('reviews', $request), 
            //     ['reviews' => new ReviewCollection()]
            // ),
        ];
    }

    public function resourceWithSelectedFields(Request $request): array
    {
        $fields = explode(',', $request->fields['users']);

        return [
            $this->mergeWhen(in_array('id', $fields), 
                ['id' => $this->id]
            ),
            $this->mergeWhen(in_array('first_name', $fields), 
                ['firstName' => $this->first_name]
            ),
            $this->mergeWhen(in_array('last_name', $fields), 
                ['lastName' => $this->last_name]
            ),
            $this->mergeWhen(in_array('email', $fields), 
                ['email' => $this->email]
            ),
            $this->mergeWhen(in_array('role', $fields), 
                ['role' => $this->role]
            ),
            $this->mergeWhen(in_array('phone_number', $fields), 
                ['phoneNumber' => $this->phone_number]
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
