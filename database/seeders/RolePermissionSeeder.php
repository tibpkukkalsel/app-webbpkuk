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
        $adminWebsite = Role::findByName('Admin Website');
        $adminFasilitas = Role::findByName('Admin Fasilitas');
        $adminDiklat = Role::findByName('Admin Diklat');

        // Superadmin mendapatkan semua permission
        $superadmin->syncPermissions(Permission::all());

        // Admin Website mendapatkan permission tertentu
        $adminWebsite->syncPermissions([
            'dashboard.view',
        ]);

        // Admin Fasilitas mendapatkan permission tertentu
        $adminFasilitas->syncPermissions([
            'dashboard.view',
        ]);

        // Admin Diklat mendapatkan permission tertentu
        $adminDiklat->syncPermissions([
            'dashboard.view',
        ]);
    }
}
