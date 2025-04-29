<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUser $request): JsonResponse
    {
        $validatedData = $request->validated();

        $user = User::create($validatedData);

        return response()->json([
            'message' => 'user created with success!',
            'user' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'message' => 'user not found!',
            ], 404);
        }

        return response()->json([
            'message' => 'user founded with success!',
            'user' => $user,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();
        $user_request = User::find($id);
        $user = auth()->user();
        if (! $user_request) {
            return response()->json([
                'message' => 'user not found!',
            ], 404);
        }

        if ($user->id !== $user_request->id) {
            return response()->json([
                'message' => 'you cannot update another user!',
            ], 403);
        }

        $user_request->update($validatedData);

        return response()->json([
            'message' => 'user updated with success!',
            'user' => $user_request->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'message' => 'user not found!',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'user deleted with success!',
        ]);
    }
}
