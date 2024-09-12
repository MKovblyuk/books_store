<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Actions\Books\DeleteBookCoverImageAction;
use App\Actions\Books\GetAllBooksWithPaginateAction;
use App\Actions\Books\GetRelatedBooksAction;
use App\Actions\Books\StoreBookAction;
use App\Actions\Books\UpdateBookAction;
use App\Actions\Books\UpdateBookCoverImageAction;
use App\Enums\BookFormat;
use App\Exceptions\General\FileExistException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreBookRequest;
use App\Http\Requests\V1\Books\UpdateBookRequest;
use App\Http\Requests\V1\Books\UploadAudioBookRequest;
use App\Http\Requests\V1\Books\UploadCoverImageRequest;
use App\Http\Requests\V1\Books\UploadElectronicBookRequest;
use App\Http\Resources\V1\Books\BookCollection;
use App\Http\Resources\V1\Books\BookResource;
use App\Http\Resources\V1\Books\FragmentCollection;
use App\Http\Resources\V1\Books\ReviewCollection;
use App\Models\V1\Books\Book;
use App\Services\Books\AudioBookStorageService;
use App\Services\Books\BookStorageServiceInterface;
use App\Services\Books\ElectronicBookStorageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    private BookStorageServiceInterface $electronicStorageService;
    private BookStorageServiceInterface $audioStorageService;

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
                'getRelatedBooks'
            ]
        ]);
    }

    public function index(GetAllBooksWithPaginateAction $action)
    {
        return new BookCollection($action->execute(request()->get('per_page', 10)));
    }

    public function store(StoreBookRequest $request, StoreBookAction $storeBookAction)
    {
        try {
            $this->authorize('create', Book::class);

            $book_id = $storeBookAction->execute($request->validated());

            if ($book_id) {
                return response()->json([
                    'message' => 'Book successfully created',
                    'id' => $book_id,
                ], 201);
            }

            return response()->json(['message' => 'Book not created'], 400);

        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(UpdateBookRequest $request, Book $book, UpdateBookAction $updateBookAction)
    {
        try {
            $this->authorize('update', $book);

            return $updateBookAction->execute($book, $request->validated())
                ? response()->json(['message' => 'Book successfully updated'], 200)
                : response()->json(['message' => 'Book not updated'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    // TODO 
    // when force deleting, delete all files or all files specific format

    public function destroy(Book $book)
    {
        try {
            $this->authorize('delete', $book);

            return $book->delete()
                ? response()->noContent()
                : response()->json(['message' => 'Book not deleted'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function deleteFormat(Book $book, string $format)
    {
        try {
            $this->authorize('deleteFormat', $book);

            $format = ucfirst($format);

            if (!BookFormat::tryFrom($format)) {
                return response()->json(['message' => 'Incorrect format'], 400);
            }

            return $book->deleteFormat(BookFormat::from($format))
                ? response()->noContent()
                : response()->json(['message' => 'Format not deleted'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function getReviews(Book $book)
    {
        $per_page = request()->get('per_page', 10);
        $reviews = $book->reviews()->orderBy('updated_at', 'desc')->paginate($per_page);

        return new ReviewCollection($reviews);
    }

    public function getPreviewFragments(Book $book)
    {
        return new FragmentCollection($book->fragments);
    }

    public function uploadCoverImage(UploadCoverImageRequest $request, Book $book, UpdateBookCoverImageAction $action)
    {
        try {
            $this->authorize('uploadFiles', Book::class);
            $action->execute($book, $request->validated('image'));
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function deleteCoverImage(Book $book, DeleteBookCoverImageAction $action) {
        try {
            $this->authorize('uploadFiles', Book::class);

            return $action->execute($book) 
                ? response()->noContent()
                : response()->json(['message' => 'Cover image not deleted'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function downloadElectronicBook(Book $book, string $extension)
    {
        try {
            $this->authorize('downloadElectronicBook', $book);

            return $this->electronicStorageService->download($book, $extension);

        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (FileNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function downloadAudioBook(Book $book, string $extension)
    {
        try {
            $this->authorize('downloadAudioBook', $book);

            return $this->audioStorageService->download($book, $extension);

        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (FileNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
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
        try {
            $this->authorize('uploadFiles', Book::class);

            $files = $request->validated('files');
            $bookId = $request->validated('bookId');

            $service->store(Book::find($bookId), $files);
            return response()->json(['message' => 'files successfully stored'], 201);

        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (FileExistException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function getLanguages() 
    {
        $languages = DB::table('books')->select('language')->distinct()->get()->map(fn($item) => $item->language);
        return response()->json(['data' => $languages]);
    }

    public function getRelatedBooks(Book $book, GetRelatedBooksAction $action)
    {
        return new BookCollection($action->execute($book));
    }
}
