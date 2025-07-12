<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ActivityLogPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create activity log permissions
        $permissions = [
            'view activity logs',
            'delete activity logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }

        // Assign permissions to super admin role
        $superAdminRole = Role::where('name', 'super admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }
    }
} 