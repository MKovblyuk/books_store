<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Enums\BookFormat;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Users\StoreUserRequest;
use App\Http\Requests\V1\Users\UpdateUserRequest;
use App\Http\Resources\V1\Books\BookCollection;
use App\Http\Resources\V1\Orders\OrderCollection;
use App\Http\Resources\V1\Users\UserCollection;
use App\Http\Resources\V1\Users\UserResource;
use App\Models\V1\Books\Book;
use App\Models\V1\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\UniqueConstraintViolationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['store']]);
    }

    public function index()
    {
        try {
            $this->authorize('viewAny', User::class);

            $users = QueryBuilder::for(User::class)
                ->allowedFields('id', 'first_name', 'last_name', 'email', 'role', 'phone_number')
                ->allowedFilters(AllowedFilter::exact('id'), 'first_name', 'last_name', 'email', 'role', 'phone_number')
                ->allowedSorts('id', 'first_name', 'last_name', 'email', 'phone_number')
                ->allowedIncludes('orders', 'reviews', 'likedBooks')
                ->get();
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return new UserCollection($users);
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
            return new OrderCollection($user->orders);
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
            return new BookCollection($user->likedBooks);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function likeBook(User $user, Book $book)
    {
        try {
            $this->authorize('update', $user);
            $user->likedBooks()->attach($book->id);
            return response('', 200);
        } catch (UniqueConstraintViolationException $e) {
            return response()->json(['message' => 'Book already liked'], 400);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function unlikeBook(User $user, Book $book)
    {
        try {
            $this->authorize('update', $user);
            $user->likedBooks()->detach($book->id);
            return response('', 200);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
