<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreReviewRequest;
use App\Http\Requests\V1\Books\UpdateReviewRequest;
use App\Http\Resources\V1\Books\ReviewCollection;
use App\Http\Resources\V1\Books\ReviewResource;
use App\Models\V1\Books\Review;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $reviews = QueryBuilder::for(Review::class)
            ->allowedFields('id', 'rating', 'review', 'user_id', 'book_id', 'updated_at')
            ->allowedFilters(
                AllowedFilter::exact('id'), 
                AllowedFilter::exact('rating'), 
                AllowedFilter::exact('user_id'), 
                AllowedFilter::exact('book_id'), 
                'updated_at'
            )
            ->allowedSorts('id', 'rating', 'updated_at')
            ->get();

        return new ReviewCollection($reviews);
    }

    public function store(StoreReviewRequest $request)
    {
        $this->authorize('create', Review::class);
        Review::create($request->validated());

        return response()->json(['message' => 'Review successfully created'], 201);
    }

    public function show(Review $review)
    {
        return new ReviewResource($review);
    }

    public function update(UpdateReviewRequest $request, Review $review)
    {
        $this->authorize('update', $review);
        $review->update($request->validated());
        
        return response()->json(['message' => 'Review successfully updated'], 200);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        return $review->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Review not deleted'], 400);
    }
}
