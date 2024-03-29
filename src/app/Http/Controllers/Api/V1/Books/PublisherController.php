<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StorePublisherRequest;
use App\Http\Requests\V1\Books\UpdatePublisherRequest;
use App\Http\Resources\V1\Books\PublisherCollection;
use App\Http\Resources\V1\Books\PublisherResource;
use App\Models\V1\Books\Publisher;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = QueryBuilder::for(Publisher::class)
            ->allowedFilters([AllowedFilter::exact('id'), 'name'])
            ->allowedFields(['id', 'name'])
            ->allowedSorts(['name'])
            ->get();

        return new PublisherCollection($publishers);
    }

    public function store(StorePublisherRequest $request)
    {
        Publisher::create($request->validated());
        return response()->json(['message' => 'Publshier successfully created', 201]);
    }

    public function show(Publisher $publisher)
    {
        return new PublisherResource($publisher);
    }

    public function update(UpdatePublisherRequest $request, Publisher $publisher)
    {
        $publisher->update($request->validated());
        return response()->json(['message' => 'Publisher successfully updated'], 200);
    }

    public function destroy(Publisher $publisher)
    {
        return $publisher->delete() 
            ? response()->noContent()
            : response()->json(['message' => "Publisher not deleted"], 500);
    }
}
