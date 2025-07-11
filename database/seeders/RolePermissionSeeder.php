<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role Management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            
            // Permission Management
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            
            // Dashboard
            'view dashboard',
            
            // Settings
            'view settings',
            'edit settings',
            
            // Profile
            'edit profile',
            'change password',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $manager = Role::create(['name' => 'Manager']);
        $user = Role::create(['name' => 'User']);

        // Super Admin gets all permissions
        $superAdmin->givePermissionTo(Permission::all());

        // Admin gets most permissions except role/permission management
        $admin->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view dashboard',
            'view settings',
            'edit settings',
            'edit profile',
            'change password',
        ]);

        // Manager gets limited permissions
        $manager->givePermissionTo([
            'view users',
            'view dashboard',
            'edit profile',
            'change password',
        ]);

        // User gets basic permissions
        $user->givePermissionTo([
            'view dashboard',
            'edit profile',
            'change password',
        ]);

        // Assign Super Admin role to the first user (if exists)
        $firstUser = User::first();
        if ($firstUser) {
            $firstUser->assignRole('Super Admin');
        }
    }
}
