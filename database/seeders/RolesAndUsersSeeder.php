<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndUsersSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // Create the "Super Admin" role and assign all permissions
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole1 = Role::create(['name' => 'user']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Create a new user
        $user = User::create([
            'name' => 'John123', 
            'email' => 'john123@example.com', 
            'password' => bcrypt('password'), 
        ]);

        // Assign the "Super Admin" role to the user
        $user->assignRole('super-admin');
    }
}


