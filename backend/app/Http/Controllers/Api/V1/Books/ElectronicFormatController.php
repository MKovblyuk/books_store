<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Actions\Books\Electronic\DeleteElectronicFormatAction;
use App\Actions\Books\Electronic\GetElectronicFormatsAction;
use App\Actions\Books\Electronic\StoreElectronicFormatAction;
use App\Actions\Books\Electronic\UpdateElectronicFormatAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreElectronicFormatRequest;
use App\Http\Requests\V1\Books\UpdateElectronicFormatRequest;
use App\Http\Resources\V1\Books\AudioFormatResource;
use App\Http\Resources\V1\Books\ElectronicFormatCollection;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use InvalidArgumentException;

class ElectronicFormatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(GetElectronicFormatsAction $action)
    {
        return new ElectronicFormatCollection($action->execute(request('per_page')));
    }

    public function storeForBook(StoreElectronicFormatRequest $request, Book $book, StoreElectronicFormatAction $action)
    {
        $this->authorize('create', Book::class);

        try {
            $action->execute($book, $request->validated());       
            return response()->json(['message' => 'Electronic format successfully created'], 201);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function show(ElectronicFormat $electronicFormat)
    {
        return new AudioFormatResource($electronicFormat);
    }

    public function update(UpdateElectronicFormatRequest $request, ElectronicFormat $electronicFormat, UpdateElectronicFormatAction $action)
    {
        $this->authorize('update', Book::class);
        $action->execute($electronicFormat->book, $request->validated());

        return response()->json(['message' => 'Electronic format successfully updated'], 200);
    }

    public function destroy(ElectronicFormat $electronicFormat, DeleteElectronicFormatAction $action)
    {
        $this->authorize('delete', Book::class);

        return $action->execute($electronicFormat)
            ? response()->noContent()
            : response()->json(['message' => "Electronic format not deleted"], 500);
    }
}
