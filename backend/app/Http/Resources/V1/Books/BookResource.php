<?php

namespace App\Http\Resources\V1\Books;

use App\Traits\AllowedIncludes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookResource extends JsonResource
{
    use AllowedIncludes;

    public function toArray(Request $request): array
    {
        if (isset($request->fields)){
            return $this->resourceWithSelectedFields($request);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'publicationYear' => $this->publication_year,
            'language' => $this->language,
            'coverImageUrl' => $this->cover_image_path ? Storage::disk('preview_fragments')->url($this->cover_image_path) : null,
            'publishedAt' => $this->published_at,
            'audioFormat' => new AudioFormatResource($this->audioFormat),
            'electronicFormat' => new ElectronicFormatResource($this->electronicFormat),
            'paperFormat' => new PaperFormatResource($this->paperFormat),
            'likedUsersIds' => $this->likedByUsers()->pluck('id'),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            $this->mergeWhen($this->fieldIsNotIncluded('publisher', $request),
                ['publisherId' => $this->publisher_id]
            ),
            $this->mergeWhen($this->fieldIsIncluded('publisher', $request),
                ['publisher' => new PublisherResource($this->publisher)]
            ),

            $this->mergeWhen($this->fieldIsNotIncluded('category', $request),
                ['categoryId' => $this->category_id]
            ),
            $this->mergeWhen($this->fieldIsIncluded('category', $request),
                ['category' => new CategoryResource($this->category)]
            ),

            $this->mergeWhen($this->fieldIsIncluded('authors', $request),
                ['authors' => new AuthorCollection($this->authors)]
            ),
            $this->mergeWhen($this->fieldIsNotIncluded('authors', $request),
                ['authorsIds' => $this->authors()->pluck('authors.id')]
            ),

            $this->mergeWhen($this->fieldIsIncluded('reviews', $request),
                ['reviews' => new ReviewCollection($this->reviews)]
            ),

            $this->mergeWhen($this->fieldIsIncluded('fragments', $request), 
                ['fragments' => new FragmentCollection($this->fragments)]
            ),
        ];
    }

    public function resourceWithSelectedFields(Request $request): array
    {
        $fields = explode(',', $request->fields['books']);

        return [
            $this->mergeWhen(in_array('id', $fields),
                ['id' => $this->id]
            ),
            $this->mergeWhen(in_array('name', $fields),
                ['name' => $this->name]
            ),
            $this->mergeWhen(in_array('description', $fields),
                ['description' => $this->description]
            ),
            $this->mergeWhen(in_array('publication_year', $fields),
                ['publicationYear' => $this->publication_year]
            ),
            $this->mergeWhen(in_array('language', $fields),
                ['language' => $this->language]
            ),
            $this->mergeWhen(in_array('cover_image_path', $fields),
                ['coverImageUrl' => $this->cover_image_path ? Storage::disk('preview_fragments')->url($this->cover_image_path) : null,]
            ),
            $this->mergeWhen(in_array('published_at', $fields),
                ['publishedAt' => $this->published_at]
            ),
            $this->mergeWhen(in_array('category_id', $fields),
                ['categoryId' => $this->category_id]
            ),
            $this->mergeWhen(in_array('publisher_id', $fields),
                ['publisherId' => $this->publisher_id]
            ),
            $this->mergeWhen(in_array('liked_users_ids', $fields), 
                ['likedUsersIds' => $this->likedByUsers()->pluck('id')]
            ),
            $this->mergeWhen(in_array('created_at', $fields),
                ['createdAt' => $this->created_at]
            ),
            $this->mergeWhen(in_array('updated_at', $fields),
                ['updatedAt' => $this->updated_at]
            ),
        ];
    }
}
