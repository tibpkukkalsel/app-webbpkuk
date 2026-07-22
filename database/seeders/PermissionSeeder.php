<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $permissions = [

            // Dashboard
            'dashboard.view',

            // Pengguna
            'pengguna.view',
            'pengguna.store ',
            'pengguna.edit',
            'pengguna.delete',
            // kategori
            'kategori.view',
            //identitas
            'identitas.view',
            //identitas
            'footer.view',
            //beranda
            'beranda.view',
            //profile
            'profile.konfig',
            //layanan
            'layanan.konfig',
            //agenda
            'agenda.konfig',
         ];
         
         foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
