<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Actions\Books\Paper\GetPaperFormatsAction;
use App\Actions\Books\Paper\UpdateOrCreatePaperFormatAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StorePaperFormatRequest;
use App\Http\Requests\V1\Books\UpdatePaperFormatRequest;
use App\Http\Resources\V1\Books\PaperFormatCollection;
use App\Http\Resources\V1\Books\PaperFormatResource;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\PaperFormat;

class PaperFormatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(GetPaperFormatsAction $action)
    {
        return new PaperFormatCollection($action->execute(request('per_page')));
    }

    public function storeForBook(StorePaperFormatRequest $request, Book $book, UpdateOrCreatePaperFormatAction $action)
    {
        $this->authorize('create', Book::class);
        $action->execute($book, $request->validated());

        return response()->json(['message' => 'Paper format successfully created'], 201);
    }

    public function show(PaperFormat $paperFormat)
    {
        return new PaperFormatResource($paperFormat);
    }

    public function update(UpdatePaperFormatRequest $request, PaperFormat $paperFormat)
    {
        $this->authorize('update', Book::class);
        $paperFormat->update($request->validated());

        return response()->json(['message' => 'Paper format successfully updated'], 200);
    }

    public function destroy(PaperFormat $paperFormat)
    {
        $this->authorize('delete', Book::class);

        return $paperFormat->delete()
            ? response()->noContent()
            : response()->json(['message' => "Paper format not deleted"], 500);
    }
}
