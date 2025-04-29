<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(Login $request): JsonResponse
    {
        $validatedData = $request->validated();

        if (! auth()->attempt(['email' => $validatedData['email'],
            'password' => $validatedData['password']])) {
            return response()->json([
                'message' => 'invalid data!',
            ], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'login realized with success!',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(): JsonResponse
    {
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'logout realized with success!',
        ]);
    }
}
