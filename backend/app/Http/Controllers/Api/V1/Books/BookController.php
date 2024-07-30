<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Enums\BookFormat;
use App\Exceptions\General\DeniedMimeTypeException;
use App\Exceptions\General\FileExistException;
use App\Helpers\DirectoryNameGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreBookRequest;
use App\Http\Requests\V1\Books\UpdateBookRequest;
use App\Http\Requests\V1\Books\UploadAudioBookRequest;
use App\Http\Requests\V1\Books\UploadBookFilesRequest;
use App\Http\Requests\V1\Books\UploadElectronicBookRequest;
use App\Http\Resources\V1\Books\BookCollection;
use App\Http\Resources\V1\Books\BookResource;
use App\Http\Resources\V1\Books\ReviewCollection;
use App\Interfaces\Repositories\BookRepositoryInterface;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use App\Models\V1\Books\PaperFormat;
use App\Models\V1\Books\Review;
use App\Services\BookFileStorageService;
use App\Services\Books\AudioBookStorageService;
use App\Services\Books\BookStorageServiceInterface;
use App\Services\Books\ElectronicBookStorageService;
use App\Services\BookService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    private BookRepositoryInterface $repository;
    private BookStorageServiceInterface $electronicStorageService;
    private BookStorageServiceInterface $audioStorageService;

    public function __construct(BookRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->electronicStorageService = new ElectronicBookStorageService();
        $this->audioStorageService = new AudioBookStorageService();

        $this->middleware('auth:sanctum', ['except' => ['index', 'show', 'getReviews']]);
    }

    public function index()
    {
        return new BookCollection($this->repository->getAll());
    }

    public function store(StoreBookRequest $request, DirectoryNameGenerator $generator)
    {
        try {
            $this->authorize('create', Book::class);

            $attributes = $request->validated();


            // move into action /////////////////////////////////////////////////////

            $book_id = DB::transaction(function () use($attributes, $generator) {

                $book = Book::create($attributes);
                $book->authors()->saveMany(Author::find($attributes['authors_ids']));

                $path = $generator->generate($book->id, $book->name);
    
                if (isset($attributes['formats']['paper'])) {
                    $book->paperFormat()->save(new PaperFormat($attributes['formats']['paper']));
                }
                if (isset($attributes['formats']['audio'])) {
                    $attributes['formats']['audio']['path'] = $path;
                    $book->audioFormat()->save(new AudioFormat($attributes['formats']['audio']));
                }
                if (isset($attributes['formats']['electronic'])) {
                    $attributes['formats']['electronic']['path'] = $path;
                    $book->electronicFormat()->save(new ElectronicFormat($attributes['formats']['electronic']));
                }

                return $book->id;
            });


            if ($book_id) {
                return response()->json([
                    'message' => 'Book successfully created',
                    'id' => $book_id,
                ], 201);
            }

            return response()->json(['message' => 'Book not created'], 400);

            // return $this->repository->store($request->validated())
            //     ? response()->json(['message' => 'Book successfully created'], 201)
            //     : response()->json(['message' => 'Book not created'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
            $this->authorize('update', $book);

            return $this->repository->update($book, $request->validated())
                ? response()->json(['message' => 'Book successfully updated'], 200)
                : response()->json(['message' => 'Book not updated'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function destroy(Book $book)
    {
        try {
            $this->authorize('delete', $book);

            return $this->repository->destroy($book)
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
        $reviews = $book->reviews()->paginate($per_page);

        return new ReviewCollection($reviews);
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
        } catch (Exception $e) {
            dd('exception');
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
}
