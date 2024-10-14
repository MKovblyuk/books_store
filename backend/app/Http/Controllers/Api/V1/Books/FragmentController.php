<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Actions\Books\StoreFragmentAction;
use App\Actions\Books\UpdateFragmentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreFragmentRequest;
use App\Http\Requests\V1\Books\UpdateFragmentRequest;
use App\Http\Resources\V1\Books\FragmentCollection;
use App\Http\Resources\V1\Books\FragmentResource;
use App\Models\V1\Books\Fragment;
use Illuminate\Auth\Access\AuthorizationException;

class FragmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return new FragmentCollection(Fragment::all());
    }

    public function store(StoreFragmentRequest $request, StoreFragmentAction $action)
    {
        try {
            $this->authorize('create', Fragment::class);
            $action->execute($request->validated('book_id'), $request->validated('file'));
            return response()->json(['message' => 'Fragment successfully created'], 201);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function show(Fragment $fragment)
    {
        return new FragmentResource($fragment);
    }

    public function update(UpdateFragmentRequest $request, Fragment $fragment, UpdateFragmentAction $action)
    {
        try {
            $this->authorize('update', $fragment);
            $action->execute($fragment, $request->validated());
            return response()->json(['message' => 'Fragment successfully updated'], 200);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function destroy(Fragment $fragment)
    {
        try {
            $this->authorize('delete', $fragment);

            return $fragment->delete()
                ? response()->noContent()
                : response()->json(['message' => 'Fragment not deleted'], 500);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
