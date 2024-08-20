<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\V1\User;
use App\Rules\PhoneNumber;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class GuestUserHandling
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('sanctum')->check()) {
            Auth::setUser(Auth::guard('sanctum')->user());
        } else {
            $guestData = $request->validate([
                'guestDetails.firstName' => ['required', 'max:75'],
                'guestDetails.lastName' => ['required', 'max:75'],
                'guestDetails.phoneNumber' => ['required', 'max:30', new PhoneNumber()],
                'guestDetails.email' => ['required', 'email'],
            ])['guestDetails'];

            $user = User::firstOrCreate(
                ['email' => $guestData['email']],
                [
                    'first_name' => $guestData['firstName'],
                    'last_name' => $guestData['lastName'],
                    'phone_number' => $guestData['phoneNumber'],
                    'email' => $guestData['email'],
                    'role' => UserRole::Guest,
                    'password' => Str::random()
                ]
            );

            Auth::setUser($user);
        }

        return $next($request);
    }
}
