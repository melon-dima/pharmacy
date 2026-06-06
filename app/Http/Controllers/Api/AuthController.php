<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return $this->tokenResponse($user, $validated['device_name'] ?? 'mobile', 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::query()->where('email', $validated['email'])->first();

        if ($user === null || ! Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Неверный email или пароль.',
            ]);
        }

        return $this->tokenResponse($user, $validated['device_name'] ?? 'mobile');
    }

    public function me(Request $request): UserResource
    {
        return UserResource::make($request->user());
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Token revoked.']);
    }

    private function tokenResponse(User $user, string $deviceName, int $status = 200): JsonResponse
    {
        $token = $user->createToken($deviceName, ['mobile'])->plainTextToken;

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => UserResource::make($user),
        ], $status);
    }
}
