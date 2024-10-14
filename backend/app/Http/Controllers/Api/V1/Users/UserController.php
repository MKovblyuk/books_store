<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Actions\Users\GetUsersAction;
use App\Actions\Users\LikeBookAction;
use App\Actions\Users\UnlikeBookAction;
use App\Enums\BookFormat;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Users\StoreUserRequest;
use App\Http\Requests\V1\Users\UpdateUserRequest;
use App\Http\Resources\V1\Books\BookCollection;
use App\Http\Resources\V1\Orders\DetailedOrderCollection;
use App\Http\Resources\V1\Users\UserCollection;
use App\Http\Resources\V1\Users\UserResource;
use App\Models\V1\Books\Book;
use App\Models\V1\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\UniqueConstraintViolationException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['store']]);
    }

    public function index(GetUsersAction $action)
    {
        try {
            $this->authorize('viewAny', User::class);
            return new UserCollection($action->execute());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
        return response()->json(['message' => 'User successfully created'], 201);
    }

    public function show(User $user)
    {
        try {
            $this->authorize('view', $user);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $this->authorize('update', $user);
            $user->update($request->validated());
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'User successfully updated'], 200);
    }

    public function destroy(User $user)
    {
        try {
            $this->authorize('delete', $user);

            return $user->delete()
                ? response()->noContent()
                : response()->json(['message' => 'User not deleted'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function getOrders(User $user)
    {
        try {
            $this->authorize('getOrders', $user);
            return new DetailedOrderCollection($user->orders()->paginate(request('per_page')));
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function getElectronicBooks(User $user)
    {
        try {
            $this->authorize('getElectronicBooks', $user);
            return new BookCollection(
                Book::withFormatForUser(BookFormat::Electronic, $user)->paginate(request('per_page'))
            );
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function getAudioBooks(User $user)
    {
        try {
            $this->authorize('getAudioBooks', $user);
            return new BookCollection(
                Book::withFormatForUser(BookFormat::Audio, $user)->paginate(request('per_page'))
            );
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function getLikedBooks(User $user)
    {
        try {
            $this->authorize('getLikedBooks', $user);
            return new BookCollection($user->likedBooks()->paginate(request('per_page')));
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function likeBook(User $user, Book $book, LikeBookAction $action)
    {
        try {
            $this->authorize('update', $user);
            $action->execute($user, $book);
            return response('', 200);
        } catch (UniqueConstraintViolationException $e) {
            return response()->json(['message' => 'Book already liked'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function unlikeBook(User $user, Book $book, UnlikeBookAction $action)
    {
        try {
            $this->authorize('update', $user);
            $action->execute($user, $book);
            return response('', 200);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
