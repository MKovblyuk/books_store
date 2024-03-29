<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreFragmentRequest;
use App\Http\Requests\V1\Books\UpdateFragmentRequest;
use App\Http\Resources\V1\Books\FragmentCollection;
use App\Http\Resources\V1\Books\FragmentResource;
use App\Models\V1\Books\Fragment;

class FragmentController extends Controller
{
    public function index()
    {
        return new FragmentCollection(Fragment::all());
    }

    public function store(StoreFragmentRequest $request)
    {
        Fragment::create($request->validated());
        return response()->json(['message' => 'Fragment successfully created'], 201);
    }

    public function show(Fragment $fragment)
    {
        return new FragmentResource($fragment);
    }

    public function update(UpdateFragmentRequest $request, Fragment $fragment)
    {
        $fragment->update($request->validated());
        return response()->json(['message' => 'Fragment successfully updated'], 200);
    }

    public function destroy(Fragment $fragment)
    {
        return $fragment->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Fragment not deleted'], 500);
    }
}
