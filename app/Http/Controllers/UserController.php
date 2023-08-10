<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        // You can assign roles to the user here if needed
        // For example:
        // $user->assignRole('user');

        return response()->json(['message' => 'User created successfully'], 201);
    }
}