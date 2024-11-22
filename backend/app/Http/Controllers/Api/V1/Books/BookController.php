<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Actions\Books\DeleteBookCoverImageAction;
use App\Actions\Books\GetBooksAction;
use App\Actions\Books\GetLanguagesAction;
use App\Actions\Books\GetRelatedBooksAction;
use App\Actions\Books\StoreBookAction;
use App\Actions\Books\UpdateBookAction;
use App\Actions\Books\UpdateBookCoverImageAction;
use App\Enums\BookFormat;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreBookRequest;
use App\Http\Requests\V1\Books\UpdateBookRequest;
use App\Http\Requests\V1\Books\UploadAudioBookRequest;
use App\Http\Requests\V1\Books\UploadCoverImageRequest;
use App\Http\Requests\V1\Books\UploadElectronicBookRequest;
use App\Http\Resources\V1\Books\AudioFormatResource;
use App\Http\Resources\V1\Books\BookCollection;
use App\Http\Resources\V1\Books\BookResource;
use App\Http\Resources\V1\Books\ElectronicFormatResource;
use App\Http\Resources\V1\Books\FragmentCollection;
use App\Http\Resources\V1\Books\PaperFormatResource;
use App\Http\Resources\V1\Books\ReviewCollection;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', [
            'except' => [
                'index', 
                'show', 
                'getReviews', 
                'getPreviewFragments', 
                'getLanguages', 
                'getRelatedBooks',
                'getPaperFormat',
                'getElectronicFormat',
                'getAudioFormat',
            ]
        ]);
    }

    public function index(GetBooksAction $action)
    {
        return new BookCollection($action->execute(request()->get('per_page', 10)));
    }

    public function store(StoreBookRequest $request, StoreBookAction $action)
    {
        $this->authorize('create', Book::class);

        $book_id = $action->execute($request->validated());

        if ($book_id) {
            return response()->json([
                'message' => 'Book successfully created',
                'id' => $book_id,
            ], 201);
        }

        return response()->json(['message' => 'Book not created'], 400);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(UpdateBookRequest $request, Book $book, UpdateBookAction $action)
    {
        $this->authorize('update', $book);

        return $action->execute($book, $request->validated())
            ? response()->json(['message' => 'Book successfully updated'], 200)
            : response()->json(['message' => 'Book not updated'], 400);
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        return $book->delete()
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

    public function getReviews(Book $book)
    {
        $reviews = $book->reviews()
            ->orderBy('updated_at', 'desc')
            ->paginate(request('per_page', 10));

        return new ReviewCollection($reviews);
    }

    public function getPreviewFragments(Book $book)
    {
        return new FragmentCollection($book->fragments);
    }

    public function uploadCoverImage(UploadCoverImageRequest $request, Book $book, UpdateBookCoverImageAction $action)
    {
        $this->authorize('uploadFiles', Book::class);
        $action->execute($book, $request->validated('image'));

        return response()->json(['message' => 'image successfully uploaded'], 201);
    }

    public function deleteCoverImage(Book $book, DeleteBookCoverImageAction $action) 
    {
        $this->authorize('uploadFiles', Book::class);

        return $action->execute($book) 
            ? response()->noContent()
            : response()->json(['message' => 'Cover image not deleted'], 400);
    }

    public function downloadElectronicBook(Book $book, string $extension)
    {
        $this->authorize('downloadElectronicBook', $book);

        if ($book->electronicFormat) {
            return $book->electronicFormat->getFileStorageService()->download($extension);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }

    public function downloadAudioBook(Book $book, string $extension)
    {
        $this->authorize('downloadAudioBook', $book);

        if ($book->audioFormat) {
            return $book->audioFormat->getFileStorageService()->download($extension);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }

    public function uploadElectronicFiles(UploadElectronicBookRequest $request)
    {
        $this->authorize('uploadFiles', Book::class);

        $electronicFormat = ElectronicFormat::where('book_id', $request->validated('bookId'))->first();

        if ($electronicFormat) {
            $electronicFormat->getFileStorageService()->store($request->validated('files'));
            return response()->json(['message' => 'files successfully stored'], 201);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }

    public function uploadAudioFiles(UploadAudioBookRequest $request)
    {
        $this->authorize('uploadFiles', Book::class);

        $audioFormat = AudioFormat::where('book_id', $request->validated('bookId'))->first();

        if ($audioFormat) {
            $audioFormat->getFileStorageService()->store($request->validated('files'));
            return response()->json(['message' => 'files successfully stored'], 201);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }

    public function getLanguages(GetLanguagesAction $action) 
    {
        return response()->json(['data' => $action->execute()]);
    }

    public function getRelatedBooks(Book $book, GetRelatedBooksAction $action)
    {
        return new BookCollection($action->execute($book, request('per_page', 10)));
    }

    public function getPaperFormat(Book $book)
    {
        if ($book->paperFormat) {
            return new PaperFormatResource($book->paperFormat);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }

    public function getElectronicFormat(Book $book)
    {
        if ($book->electronicFormat) {
            return new ElectronicFormatResource($book->electronicFormat);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }

    public function getAudioFormat(Book $book)
    {
        if ($book->audioFormat) {
            return new AudioFormatResource($book->audioFormat);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }

    public function deleteElectronicFile(Book $book, string $extension)
    {
        $this->authorize('deleteFormat', $book);
        
        if ($book->electronicFormat) {
            return $book->electronicFormat->getFileStorageService()->deleteFile($extension)
                ? response()->noContent()
                : response()->json(['message' => 'File not deleted'], 400);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }

    public function deleteAudioFile(Book $book, string $extension)
    {
        $this->authorize('deleteFormat', $book);

        if ($book->audioFormat) {
            return $book->audioFormat->getFileStorageService()->deleteFile($extension)
                ? response()->noContent()
                : response()->json(['message' => 'File not deleted'], 400);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }
}
