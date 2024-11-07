<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Actions\Users\GetUserDetailsAction;
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
use App\Http\Resources\V1\Users\UserDetailsResource;
use App\Http\Resources\V1\Users\UserResource;
use App\Models\V1\Books\Book;
use App\Models\V1\User;
use Illuminate\Database\UniqueConstraintViolationException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['store']]);
    }

    public function index(GetUsersAction $action)
    {
        $this->authorize('viewAny', User::class);
        return new UserCollection($action->execute(request('per_page', 10)));
    }

    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
        return response()->json(['message' => 'User successfully created'], 201);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update($request->validated());

        return response()->json(['message' => 'User successfully updated'], 200);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        return $user->delete()
            ? response()->noContent()
            : response()->json(['message' => 'User not deleted'], 400);
    }

    public function getOrders(User $user)
    {
        $this->authorize('getOrders', $user);
        return new DetailedOrderCollection($user->orders()->paginate(request('per_page')));
    }

    public function getElectronicBooks(User $user)
    {
        $this->authorize('getElectronicBooks', $user);
        return new BookCollection(
            Book::withFormatForUser(BookFormat::Electronic, $user)->paginate(request('per_page'))
        );
    }

    public function getAudioBooks(User $user)
    {
        $this->authorize('getAudioBooks', $user);
        return new BookCollection(
            Book::withFormatForUser(BookFormat::Audio, $user)->paginate(request('per_page'))
        );
    }

    public function getLikedBooks(User $user)
    {
        $this->authorize('getLikedBooks', $user);
        return new BookCollection($user->likedBooks()->paginate(request('per_page')));
    }

    public function likeBook(User $user, Book $book, LikeBookAction $action)
    {
        try {
            $this->authorize('update', $user);
            $action->execute($user, $book);
            return response('', 200);
        } catch (UniqueConstraintViolationException $e) {
            return response()->json(['message' => 'Book already liked'], 400);
        } 
    }

    public function unlikeBook(User $user, Book $book, UnlikeBookAction $action)
    {
        $this->authorize('update', $user);
        $action->execute($user, $book);
        return response('', 200);
    }

    public function getDetails(User $user, GetUserDetailsAction $action)
    {
        $this->authorize('view', $user);
        return new UserDetailsResource($action->execute($user));
    }
}
