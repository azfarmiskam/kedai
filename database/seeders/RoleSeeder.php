<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles with guard_name
        $superAdmin = \Spatie\Permission\Models\Role::firstOrCreate(
            ['name' => 'superadmin'],
            ['guard_name' => 'web']
        );
        $admin = \Spatie\Permission\Models\Role::firstOrCreate(
            ['name' => 'admin'],
            ['guard_name' => 'web']
        );
        $seller = \Spatie\Permission\Models\Role::firstOrCreate(
            ['name' => 'seller'],
            ['guard_name' => 'web']
        );
        $buyer = \Spatie\Permission\Models\Role::firstOrCreate(
            ['name' => 'buyer'],
            ['guard_name' => 'web']
        );

        // Create permissions with guard_name
        $permissions = [
            'manage-system-settings',
            'manage-admins',
            'manage-sellers',
            'manage-subscription-plans',
            'view-analytics',
            'manage-products',
            'manage-orders',
            'manage-pages',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }

        // Assign permissions to roles
        $superAdmin->syncPermissions($permissions);
        $admin->syncPermissions(['manage-sellers', 'view-analytics']);
        $seller->syncPermissions(['manage-products', 'manage-orders', 'manage-pages']);
    }
}
