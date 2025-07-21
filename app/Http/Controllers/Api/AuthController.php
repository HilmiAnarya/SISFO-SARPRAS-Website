<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'data' => [
                'id_user' => $user->id_user,  // ← ✅ ini diperbaiki
                'name'    => $user->name,
                'email'   => $user->email,
                'role'    => $user->role,
                'token'   => $token,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'id_user' => $user->id_user,  // ← ✅ ini juga diperbaiki
                'name'    => $user->name,
                'email'   => $user->email,
                'role'    => $user->role,
            ]
        ], 200);
    }
}
