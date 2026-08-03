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
        $adminKemasan = Role::findByName('Admin Layanan Kemasan');
        $adminHelpdesk = Role::findByName('Admin Helpdesk');

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

        // Admin Layanan Kemasan mendapatkan permission tertentu
        $adminKemasan->syncPermissions([
            'dashboard.view',
        ]);

        // Admin Helpdesk mendapatkan permission kontak
        $adminHelpdesk->syncPermissions([
            'dashboard.view',
            'kontak.view',
            'kontak.reply',
            'kontak.delete',
        ]);
    }
}
