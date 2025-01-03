<?php

namespace App\Http\Resources\V1\Books;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RelatedBookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'coverImageUrl' => $this->cover_image_path ? Storage::disk('preview_fragments')->url($this->cover_image_path) : null,
            'audioFormat' => new AudioFormatResource($this->audioFormat),
            'electronicFormat' => new ElectronicFormatResource($this->electronicFormat),
            'paperFormat' => new PaperFormatResource($this->paperFormat),
        ];
    }
}
