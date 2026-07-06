<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan updateOrCreate agar tidak error jika data sudah ada
        User::updateOrCreate(
            ['email' => 'admin@spendwise.com'], // Cek apakah email ini sudah ada
            [
                'name' => 'Admin SpendWise',
                'password' => Hash::make('password123'), // Ganti dengan password yang Anda inginkan
                'role' => 'admin', // Pastikan kolom role diset jadi 'admin'
            ]
        );
    }
}