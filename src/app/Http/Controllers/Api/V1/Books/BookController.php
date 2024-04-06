<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Enums\BookFormat;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreBookRequest;
use App\Http\Requests\V1\Books\UpdateBookRequest;
use App\Http\Resources\V1\Books\BookCollection;
use App\Http\Resources\V1\Books\BookResource;
use App\Interfaces\Repositories\BookRepositoryInterface;
use App\Models\V1\Books\Book;

class BookController extends Controller
{
    public function __construct(
        private BookRepositoryInterface $repository
    )
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return new BookCollection($this->repository->getAll());
    }

    public function store(StoreBookRequest $request)
    {
        $this->authorize('create', Book::class);

        return $this->repository->store($request->validated())
            ? response()->json(['message' => 'Book successfully created'], 201)
            : response()->json(['message' => 'Book not created'], 400);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $this->authorize('update', $book);

        return $this->repository->update($book, $request->validated())
            ? response()->json(['message' => 'Book successfully updated'], 200)
            : response()->json(['message' => 'Book not updated'], 400);
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        return $this->repository->destroy($book)
            ? response()->noContent()
            : response()->json(['message' => 'Book not deleted'], 400);
    }

    public function deleteFormat(Book $book, string $format)
    {
        $this->authorize('deleteFormat', $book);

        $format = ucfirst($format);

        if (!BookFormat::tryFrom($format)) {
            return response()->json(['message' => 'Incorrect format'], 400);
        }

        return $book->deleteFormat(BookFormat::from($format))
            ? response()->noContent()
            : response()->json(['message' => 'Format not deleted'], 400);
    }

    public function buy(Book $book, string $format)
    {
        // create token or create token in order method
    }

    public function download(Book $book, string $format)
    {
        // check token and download the book
    }
}
