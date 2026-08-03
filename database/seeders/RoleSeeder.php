<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus role 'Admin' lama jika ada
        Role::where('name', 'Admin')->delete();

        Role::firstOrCreate([
            'name' => 'Superadmin',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Admin Website',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Admin Fasilitas',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Admin Diklat',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Admin Layanan Kemasan',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Admin Helpdesk',
            'guard_name' => 'web',
        ]);
    }
}
