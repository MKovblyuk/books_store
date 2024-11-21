<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Actions\Books\DeleteBookCoverImageAction;
use App\Actions\Books\GetAllBooksWithPaginateAction;
use App\Actions\Books\GetLanguagesAction;
use App\Actions\Books\GetRelatedBooksWithPaginateAction;
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
use App\Models\V1\Books\Book;
use App\Services\Books\AudioBookStorageService;
use App\Services\Books\BookStorageServiceInterface;
use App\Services\Books\ElectronicBookStorageService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private ElectronicBookStorageService $electronicStorageService;
    private AudioBookStorageService $audioStorageService;

    public function __construct()
    {
        $this->electronicStorageService = new ElectronicBookStorageService();
        $this->audioStorageService = new AudioBookStorageService();

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

    public function index(GetAllBooksWithPaginateAction $action)
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

    // TODO 
    // when force deleting, delete all files or all files specific format

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
        return $this->electronicStorageService->download($book, $extension);
    }

    public function downloadAudioBook(Book $book, string $extension)
    {
        $this->authorize('downloadAudioBook', $book);
        return $this->audioStorageService->download($book, $extension);
    }


    public function uploadElectronicFiles(UploadElectronicBookRequest $request)
    {
        return $this->uploadFiles($request, $this->electronicStorageService);
    }

    public function uploadAudioFiles(UploadAudioBookRequest $request)
    {
        return $this->uploadFiles($request, $this->audioStorageService);
    }

    private function uploadFiles(Request $request, BookStorageServiceInterface $service)
    {
        $this->authorize('uploadFiles', Book::class);

        $files = $request->validated('files');
        $bookId = $request->validated('bookId');

        $service->store(Book::find($bookId), $files);
        return response()->json(['message' => 'files successfully stored'], 201);
    }

    public function getLanguages(GetLanguagesAction $action) 
    {
        return response()->json(['data' => $action->execute()]);
    }

    public function getRelatedBooks(Book $book, GetRelatedBooksWithPaginateAction $action)
    {
        return new BookCollection($action->execute($book, request('per_page', 10)));
    }

    public function getPaperFormat(Book $book)
    {
        $format = $book->getFormat(BookFormat::Paper);

        if ($format) {
            return new PaperFormatResource($format);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }

    public function getElectronicFormat(Book $book)
    {
        $format = $book->getFormat(BookFormat::Electronic);

        if ($format) {
            return new ElectronicFormatResource($format);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }

    public function getAudioFormat(Book $book)
    {
        $format = $book->getFormat(BookFormat::Audio);

        if ($format) {
            return new AudioFormatResource($format);
        }

        return response()->json(['message' => 'Format not found'], 404);
    }
}
