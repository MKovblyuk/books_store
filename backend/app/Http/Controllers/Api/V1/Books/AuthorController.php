<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Actions\Books\GetAuthorsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreAuthorRequest;
use App\Http\Requests\V1\Books\UpdateAuthorRequest;
use App\Http\Resources\V1\Books\AuthorCollection;
use App\Http\Resources\V1\Books\AuthorResource;
use App\Models\V1\Books\Author;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(GetAuthorsAction $action)
    {
        return new AuthorCollection($action->execute(request('per_page', 10)));
    }

    public function store(StoreAuthorRequest $request)
    {
        $this->authorize('create', Author::class);
        Author::create($request->validated());

        return response()->json(['message' => 'Author successfully created'], 201);
    }

    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $this->authorize('update', $author);
        $author->update($request->validated());

        return response()->json(['message' => 'Author successfully updated'], 200);
    }

    public function destroy(Author $author)
    {
        $this->authorize('delete', $author);

        return $author->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Author not deleted'], 500);
    }
}
