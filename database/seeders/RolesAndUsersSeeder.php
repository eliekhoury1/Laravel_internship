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
        Permission::create(['name' => 'edit articles', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete articles', 'guard_name' => 'web']);
        Permission::create(['name' => 'publish articles', 'guard_name' => 'web']);
        Permission::create(['name' => 'unpublish articles', 'guard_name' => 'web']);

        // Define roles and their permissions
        $roles = [
            'super-admin' => [],
            'admin' => [],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::updateOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }

    
        $spadmin = User::updateOrCreate(
            ['email' => 'superAdmin@gmail.com'], 
            [
                'name' => 'super admin',
                'password' => bcrypt('password'),
            ]
        );

  
        $adminRole = Role::findByName('admin');

        $spadminRole = Role::findByName('super-admin');

      
        $newAdmin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'AdminUser',
                'password' => bcrypt('password'),
            ]
        );
        
        // Assign 'admin' role to the new users
        $newAdmin->syncRoles([$adminRole]);
        $spadmin->syncRoles([$spadminRole]);
    }
}