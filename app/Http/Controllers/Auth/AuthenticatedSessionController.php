<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();
        // Create a token for the authenticated user
        $tokenResult = $request->user()->createToken('authToken'); // 'authToken' is the name of the token
        $token = $tokenResult->plainTextToken;

        // Return the token in the response
        return response()->json([
            'user' => Auth::user(),
            'token' => $token]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        return response()->json(['message' => 'No user logged in'], 401);
    }
}
