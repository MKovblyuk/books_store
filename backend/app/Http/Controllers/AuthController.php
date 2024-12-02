<?php

namespace App\Http\Controllers;

use App\Http\Requests\V1\Users\LoginUserRequest;
use App\Http\Requests\V1\Users\StoreUserRequest;
use App\Models\V1\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {        
        $credentials = [
            'email' => $request->validated('email'),
            'password' => $request->validated('password'),
        ];

        if (Auth::attempt($credentials, $request->validated('remember'))) {

            if (isset($request->session)) {
                $request->session()->regenerate();
            }

            $user = Auth::user();
            $expirationMinutes = $request->validated('remember') ? now()->addDays(14) : now()->addDays(2);
            $customerToken = $user->createToken(
                $user->role->name . '_token_' . $user->id, 
                ['*'], 
                $expirationMinutes
            );

            return response()->json([
                'message' => 'User successfully logged in',
                'token' => $customerToken->plainTextToken,
                'userId' => $user->id,
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
            $customerToken = $user->createToken($user->role->name . '_token_' . $user->id);

            return response()->json([
                'message' => 'User successfully registered',
                'token' => $customerToken->plainTextToken,
                'userId' => $user->id,
            ], 201);
        }

    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        if (isset($request->session)) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        
        return response()->json(['message' => 'User logged out'], 200);
    }
}
