<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRegisterRequest;
use App\Http\Requests\LoginVerifyRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function register(LoginRegisterRequest $request): JsonResponse
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        /** @var User $user */
        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
        ]);

        if (empty($user)) {
            return response()->json([
                'message' => "Could not process user with name:$name and email: $email"
            ], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(LoginVerifyRequest $request): JsonResponse
    {
        $email = $request->get('email');
        $password = $request->get('password');

        /** @var User $user */
        $user = User::query()->where('email', $email)->first();

        if (empty($user) || ! Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function profile(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
