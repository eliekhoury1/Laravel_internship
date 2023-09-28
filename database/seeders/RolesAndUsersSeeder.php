<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesAndUsersSeeder extends Seeder
{
    public function run()
    {
        // Define roles (without permissions)
        $roles = [
            'super-admin',
            'admin',
        ];

        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }

       // Create or update 'super admin' user with 'super-admin' role
       User::create(
        ['email' => 'superAdmin@gmail.com'],
        [
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
        ]
    );
    }
}