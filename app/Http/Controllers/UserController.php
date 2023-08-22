<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

        
        // Create a new user instance and save it
        $user = new User($data);
        $user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    }


    public function index($userId)
    {
        $authenticatedUserId = Auth::id(); // Get the authenticated user's ID
        
        // Check if the authenticated user's ID matches the requested user's ID
        if ($authenticatedUserId == $userId) {
            $user = User::find($userId);

            if (!$user) {
                return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['data' => $user], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    }



    public function show($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $user], Response::HTTP_OK);
    }

    public function update(Request $request, User $user)
    {
        // Validate request data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|min:6',
        ]);

        $data['password'] = bcrypt($data['password']);

        // Update user data
        $user->update($data);

        return response()->json(['message' => 'User updated successfully'], Response::HTTP_OK);
    }

    public function destroy(User $user)
    {
        // Delete user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }
    
}