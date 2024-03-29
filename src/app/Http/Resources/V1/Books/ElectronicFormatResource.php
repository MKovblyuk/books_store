<?php

namespace App\Http\Resources\V1\Books;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ElectronicFormatResource extends JsonResource
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
            'price' => $this->price,
            'discount' => $this->discount,
            'pageCount' => $this->page_count,
            'url' => $this->url,
        ];
    }
}
