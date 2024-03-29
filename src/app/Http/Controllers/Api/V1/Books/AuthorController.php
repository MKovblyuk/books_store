<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreAuthorRequest;
use App\Http\Requests\V1\Books\UpdateAuthorRequest;
use App\Http\Resources\V1\Books\AuthorCollection;
use App\Http\Resources\V1\Books\AuthorResource;
use App\Models\V1\Books\Author;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = QueryBuilder::for(Author::class)
            ->allowedFilters([AllowedFilter::exact('id'), 'first_name', 'last_name'])
            ->allowedFields(['id', 'first_name', 'last_name', 'description', 'photo_url'])
            ->allowedSorts(['id', 'first_name', 'last_name'])
            ->get();

        return new AuthorCollection($authors);
    }

    public function store(StoreAuthorRequest $request)
    {
        Author::create($request->validated());
        return response()->json(['message' => 'Author successfully created'], 201);
    }

    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        return response()->json(['message' => 'Author successfully updated'], 200);
    }

    public function destroy(Author $author)
    {
        return $author->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Author not deleted'], 500);
    }
}
