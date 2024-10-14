<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Actions\Books\GetPublishersAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StorePublisherRequest;
use App\Http\Requests\V1\Books\UpdatePublisherRequest;
use App\Http\Resources\V1\Books\PublisherCollection;
use App\Http\Resources\V1\Books\PublisherResource;
use App\Models\V1\Books\Publisher;
use Illuminate\Auth\Access\AuthorizationException;

class PublisherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(GetPublishersAction $action)
    {
        return new PublisherCollection($action->execute());
    }

    public function store(StorePublisherRequest $request)
    {
        try {
            $this->authorize('create', Publisher::class);
            Publisher::create($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'Publshier successfully created'], 201);
    }

    public function show(Publisher $publisher)
    {
        return new PublisherResource($publisher);
    }

    public function update(UpdatePublisherRequest $request, Publisher $publisher)
    {
        try {
            $this->authorize('update', $publisher);
            $publisher->update($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'Publisher successfully updated'], 200);
    }

    public function destroy(Publisher $publisher)
    {
        try {
            $this->authorize('delete', $publisher);

            return $publisher->delete()
                ? response()->noContent()
                : response()->json(['message' => "Publisher not deleted"], 500);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
