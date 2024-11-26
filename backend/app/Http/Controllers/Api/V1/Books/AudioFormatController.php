<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Actions\Books\Audio\DeleteAudioFormatAction;
use App\Actions\Books\Audio\StoreAudioFormatAction;
use App\Actions\Books\Audio\UpdateAudioFormatAction;
use App\Actions\Books\Audio\GetAudioFormatsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreAudioFormatRequest;
use App\Http\Requests\V1\Books\UpdateAudioFormatRequest;
use App\Http\Resources\V1\Books\AudioFormatCollection;
use App\Http\Resources\V1\Books\AudioFormatResource;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Book;
use InvalidArgumentException;

class AudioFormatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(GetAudioFormatsAction $action)
    {
        return new AudioFormatCollection($action->execute(request('per_page')));
    }

    public function storeForBook(StoreAudioFormatRequest $request, Book $book, StoreAudioFormatAction $action)
    {
        $this->authorize('create', Book::class);

        try {
            $action->execute($book, $request->validated());       
            return response()->json(['message' => 'Audio format successfully created'], 201);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function show(AudioFormat $audioFormat)
    {
        return new AudioFormatResource($audioFormat);
    }

    public function update(UpdateAudioFormatRequest $request, AudioFormat $audioFormat, UpdateAudioFormatAction $action)
    {
        $this->authorize('update', Book::class);
        $action->execute($audioFormat->book, $request->validated());

        return response()->json(['message' => 'Audio format successfully updated'], 200);
    }

    public function destroy(AudioFormat $audioFormat, DeleteAudioFormatAction $action)
    {
        $this->authorize('delete', Book::class);

        return $action->execute($audioFormat)
            ? response()->noContent()
            : response()->json(['message' => "Audio format not deleted"], 500);
    }
}
