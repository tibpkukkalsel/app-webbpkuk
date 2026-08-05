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

        // Admin Website mendapatkan permission berita, artikel, info tips
        $adminWebsite->syncPermissions([
            'dashboard.view',
            'post.konfig',
        ]);

        // Admin Fasilitas mendapatkan permission fasilitas
        $adminFasilitas->syncPermissions([
            'dashboard.view',
            'fasilitas.konfig',
        ]);

        // Admin Diklat mendapatkan permission dashboard diklat
        $adminDiklat->syncPermissions([
            'dashboard.view',
            'layanan.konfig',
        ]);

        // Admin Layanan Kemasan mendapatkan permission post dan produk umkm
        $adminKemasan->syncPermissions([
            'dashboard.view',
            'post.konfig',
            'produk_umkm.view',
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
