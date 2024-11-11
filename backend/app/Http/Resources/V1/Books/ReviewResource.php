<?php

namespace App\Http\Resources\V1\Books;

use App\Models\V1\User;
use App\Traits\AllowedIncludes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    use AllowedIncludes;

    public function toArray(Request $request): array
    {
        $user = User::find($this->user_id);

        if (isset($request->fields)) {
            return $this->resourceWithSelectedFields($request, $user);
        }

        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'review' => $this->review,
            'userId' => $this->user_id,
            'userFirstName' => $user->first_name,
            'userLastName' => $user->last_name,
            'updatedAt' => $this->updated_at,
            $this->mergeWhen($this->fieldIsIncluded('book', $request), [
                'book' => $this->book,
            ]),
            $this->mergeWhen($this->fieldIsNotIncluded('book', $request), [
                'bookId' => $this->book_id,
            ]),
        ];
    }

    private function resourceWithSelectedFields(Request $request, User $user): array
    {
        $fields = explode(',', $request->fields['reviews']);

        return [
            $this->mergeWhen(in_array('id', $fields),
                ['id' => $this->id]
            ),
            $this->mergeWhen(in_array('rating', $fields),
                ['rating' => $this->rating]
            ),
            $this->mergeWhen(in_array('review', $fields),
                ['review' => $this->review]
            ),
            $this->mergeWhen(in_array('user_id', $fields),
                ['userId' => $this->user_id]
            ),
            $this->mergeWhen(in_array('user_first_name', $fields),
                ['userFirstName' => $user->first_name]
            ),
            $this->mergeWhen(in_array('user_last_name', $fields), 
                ['userLastName' => $user->last_name]
            ),
            $this->mergeWhen(in_array('book_id', $fields),
                ['bookId' => $this->book_id]
            ),
            $this->mergeWhen(in_array('updated_at', $fields),
                ['updatedAt' => $this->updated_at]
            ),
        ];
    }
}
