<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Actions\Reviews\GetReviewsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreReviewRequest;
use App\Http\Requests\V1\Books\UpdateReviewRequest;
use App\Http\Resources\V1\Books\ReviewCollection;
use App\Http\Resources\V1\Books\ReviewResource;
use App\Models\V1\Books\Review;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(GetReviewsAction $action)
    {
        return new ReviewCollection($action->execute(request('per_page', 15)));
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
