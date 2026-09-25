<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $defaultPassword = config('auth.admin_default_password') ?? 'cicalengkajuara';

        // 1. Akun Super Admin (Akses Utama)
        User::updateOrCreate(
            ['email' => 'admin@cicalengka.go.id'],
            [
                'name' => 'Super Admin Cicalengka',
                'password' => Hash::make($defaultPassword),
                'role' => 'super_admin',
            ]
        );

        // 2. Akun Contoh Admin (Staf / Petugas)
        User::updateOrCreate(
            ['email' => 'petugas@cicalengka.go.id'],
            [
                'name' => 'Petugas Admin Cicalengka',
                'password' => Hash::make($defaultPassword),
                'role' => 'admin',
            ]
        );
    }
}
