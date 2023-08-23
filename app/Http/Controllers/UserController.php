<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller


{
   // public function store(Request $request)
    //{
    //    $data = $request->validate([
     //       'name' => 'required|string|max:255',
      //      'email' => 'required|email|unique:users',
       //     'password' => 'required|min:6',
       // ]);

       // $data['password'] = bcrypt($data['password']);

        
        // Create a new user instance and save it
       /// $user = new User($data);
        //$user->save();

        //return response()->json(['message' => 'User created successfully'], 201);
    //}

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    $data['password'] = Hash::make($data['password']); // Use Hash::make for password hashing

    // Use the create method to create and save the new user instance
    User::create($data);

    return response()->json(['message' => 'User created successfully'], 201);
}


    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(['name', 'email']) // Add allowed filters
            ->allowedSorts(['name', 'email'])   // Add allowed sorts
            ->defaultSort('-created_at')        // Set default sort order
            ->paginate(10);                     // Apply pagination
    
        return response()->json(['data' => $users], Response::HTTP_OK);
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