<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return new JsonResponse([
                'message' => __('auth.incorrect_credentials'),
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::whereEmail($request->email)
            ->first();

        return new JsonResponse([
            'token' => $user->createToken('api_key')->plainTextToken,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        session()->flush();

        return new JsonResponse(status: 204);
    }

    public function user(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
