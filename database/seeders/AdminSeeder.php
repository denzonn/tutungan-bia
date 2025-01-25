<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Tambahkan SuperAdmin
        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'], // Cek jika sudah ada user dengan email ini
            [
                'name' => 'SuperAdmin',
                'password' => bcrypt('123'), // Enkripsi password
            ]
        );
        $superadmin->assignRole('SUPERADMIN'); // Tetapkan role SUPERADMIN ke user

        // Tambahkan Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin123@gmail.com'], // Cek jika sudah ada user dengan email ini
            [
                'name' => 'Admin',
                'password' => bcrypt('123'), // Enkripsi password
            ]
        );
        $admin->assignRole('ADMIN'); // Tetapkan role ADMIN ke user
    }
}
