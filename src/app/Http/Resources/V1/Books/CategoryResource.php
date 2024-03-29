<?php

namespace App\Http\Resources\V1\Books;

use App\Models\V1\Books\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'parentId' => $this->parent_id,
            'children' => new CategoryCollection(Category::find($this->id)->children()->get()),
        ];
    }
}
