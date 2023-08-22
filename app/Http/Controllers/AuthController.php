<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthController;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->where('name', $request->user()->currentAccessToken()->name)->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}