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
        // Define permissions
        Permission::updateOrCreate(['name' => 'edit articles', 'guard_name' => 'web']);
        Permission::updateOrCreate(['name' => 'delete articles', 'guard_name' => 'web']);
        Permission::updateOrCreate(['name' => 'publish articles', 'guard_name' => 'web']);
        Permission::updateOrCreate(['name' => 'unpublish articles', 'guard_name' => 'web']);

        // Define roles and their permissions
        $roles = [
            'super-admin' => ['edit articles', 'delete articles', 'publish articles', 'unpublish articles'],
            'admin' => [],
            'user' => [],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::updateOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }

        // Create or update 'john123' user with 'super-admin' role
        $john123 = User::updateOrCreate(
            ['email' => 'john1234@example.com'], // Use email as the unique identifier
            [
                'name' => 'John123',
                'password' => bcrypt('password'),
            ]
        );

        // Fetch the "admin" role using its name
        $adminRole = Role::findByName('admin');

        // Assign 'admin' role to the new users
        $newAdmin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'AdminUser',
                'password' => bcrypt('password'),
            ]
        );
        
        // Assign 'admin' role to the new users
        $newAdmin->syncRoles([$adminRole]);
    }
}