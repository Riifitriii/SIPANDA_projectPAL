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
        User::updateOrCreate(
            ['email' => 'admin@cicalengka.go.id'],
            [
                'name' => 'Admin Cicalengka',
                'password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD') ?? \Illuminate\Support\Str::random(16)),
            ]
        );
    }
}
