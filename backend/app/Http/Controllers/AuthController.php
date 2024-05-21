<?php

namespace App\Http\Controllers;

use App\Http\Requests\V1\Users\LoginUserRequest;
use App\Http\Requests\V1\Users\StoreUserRequest;
use App\Models\V1\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {        
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $customerToken = $user->createToken('customer_token_' . $user->id);

            return response()->json([
                'message' => 'User successfully logged in',
                'token' => $customerToken->plainTextToken,
            ], 200);
        }

        return response()->json(['message' => 'Inccorect credentials'], 400);
    }

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();

        User::create($validated);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $customerToken = $user->createToken('customer_token_' . $user->id);

            return response()->json([
                'message' => 'User successfully registered',
                'token' => $customerToken->plainTextToken,
            ], 201);
        }

    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        
        return response()->json(['message' => 'User logged out'], 200);
    }
}