<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'viewDashboard',
            'viewBerita',
            'editBerita',
            'viewArtikel',
            'editArtikel',
            'viewKategoriArtikel',
            'viewProfil',
            'viewDokumen',
            'viewPengguna',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Membuat role dan memberikan permission
        $superadmin = Role::updateOrCreate(['name' => 'SUPERADMIN'], ['name' => 'SUPERADMIN']);
        $superadmin->givePermissionTo(Permission::all()); // Memberikan semua permission ke SUPERADMIN

        $admin = Role::updateOrCreate(['name' => 'ADMIN'], ['name' => 'ADMIN']);
        $admin->givePermissionTo([
            'viewDashboard',
            'viewBerita',
            'editBerita',
            'viewArtikel',
            'editArtikel',
        ]);

        $contributor = Role::updateOrCreate(['name' => 'CONTRIBUTOR'], ['name' => 'CONTRIBUTOR']);
        $contributor->givePermissionTo([
            'viewDashboard',
            'viewBerita',
            'editBerita',
            'viewArtikel',
            'editArtikel',
        ]);
    }
}
