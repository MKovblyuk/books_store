<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Users\StoreUserRequest;
use App\Http\Requests\V1\Users\UpdateUserRequest;
use App\Http\Resources\V1\Users\UserCollection;
use App\Http\Resources\V1\Users\UserResource;
use App\Models\V1\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFields('id', 'first_name', 'last_name', 'email', 'role', 'phone_number')
            ->allowedFilters(AllowedFilter::exact('id'), 'first_name', 'last_name', 'email', 'role', 'phone_number')
            ->allowedSorts('id', 'first_name', 'last_name', 'email', 'phone_number')
            ->allowedIncludes('orders', 'reviews', 'likedBooks')
            ->get();

        return new UserCollection($users);
    }

    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
        return response()->json(['message' => 'User successfully created'], 201);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json(['message' => 'User successfully updated'], 200);
    }

    public function destroy(User $user)
    {
        return $user->delete()
            ? response()->noContent()
            : response()->json(['message' => 'User not deleted'], 400);
    }
}
