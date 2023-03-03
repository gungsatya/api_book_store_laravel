<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * @group Api Auth
 */
class ApiAuthController extends Controller
{

    public function register(Request $request, CreateNewUser $createNewUser): JsonResponse
    {
        $user = $createNewUser->create($request->all());

        return response()->json([
            'message' => 'Register successful',
            'user' => new UserResource($user),
            'token' => $user->createToken(time())->plainTextToken,
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        }

        return response()->json([
            'error' => 'Unauthenticated'
        ], 401);
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }

    public function showProfileInformation(): JsonResponse
    {
        $user = Auth::user();
        return response()->json([
            'user' => new UserResource($user)
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function updateProfileInformation(Request $request, UpdateUserProfileInformation $updateProfile): JsonResponse
    {
        $user = Auth::user();
        $updateProfile->update($user, $request->all());

        return response()->json([
            'message' => 'Update user profile successful',
            'user' => new UserResource($user),
        ]);
    }

    public function refreshToken(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        $token = $user->createToken(time())->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token
        ], 200);
    }
}
