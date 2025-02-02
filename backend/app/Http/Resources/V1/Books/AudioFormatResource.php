<?php

namespace App\Http\Resources\V1\Books;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AudioFormatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'discount' => $this->discount,
            'duration' => $this->duration,
            'files' => $this->getFileStorageService()->getAllFiles(),
        ];
    }
}
