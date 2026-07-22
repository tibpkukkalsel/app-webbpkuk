<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = Role::findByName('Superadmin');
        $admin = Role::findByName('Admin');

        // Superadmin mendapatkan semua permission
        $superadmin->syncPermissions(Permission::all());

        // Admin mendapatkan permission tertentu
        $admin->syncPermissions([
            'dashboard.view',
        ]);
    }
}
