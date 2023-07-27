<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Assuming your User model is in the "App" namespace

class RolesAndUsersSeeder extends Seeder
{
    public function run()
    {
        // Create a new user with the "Super Admin" role
        $user = User::create([
            'name' => 'John', // Replace with the desired name
            'email' => 'john@example.com', // Replace with the desired email
            'password' => 'password', // Replace 'password' with the desired password
            'role' => 'Super Admin',
        ]);
    }
}