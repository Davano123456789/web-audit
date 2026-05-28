<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Account
        User::updateOrCreate(
            ['email' => 'admin@webaudit.com'],
            [
                'name' => 'Admin Dashboard',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Asesor Account
        User::updateOrCreate(
            ['email' => 'asesor@webaudit.com'],
            [
                'name' => 'Asesor Utama',
                'password' => Hash::make('password'),
                'role' => 'asesor',
            ]
        );
    }
}
